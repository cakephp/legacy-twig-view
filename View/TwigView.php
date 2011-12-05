<?php
/**
 * TwigView for CakePHP
 *
 * About Twig
 *  http://www.twig-project.org/
 *
 * @version 0.5
 * @package TwigView
 * @subpackage TwigView.View
 * @author Kjell Bublitz <m3nt0r.de@gmail.com>
 * @link http://github.com/m3nt0r My GitHub
 * @link http://twitter.com/m3nt0r My Twitter
 * @author Graham Weldon (http://grahamweldon.com)
 * @license The MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
if (!defined('TWIG_VIEW_CACHE')) {
	define('TWIG_VIEW_CACHE', CakePlugin::path('TwigView') . 'tmp' . DS . 'views');
}

// Load Twig Lib and start auto loader
require_once(CakePlugin::path('TwigView') . 'Vendor' . DS . 'Twig' . DS . 'lib' . DS . 'Twig' . DS . 'Autoloader.php');
Twig_Autoloader::register();

// overwrite twig classes (thanks to autoload, no problem)
App::import('Lib', 'TwigView.Twig_Node_Trans');
App::import('Lib', 'TwigView.Twig_Tokenparser_Trans');

// my custom cake extensions
App::import('Lib', 'TwigView.Twig_Extension_I18n');
App::import('Lib', 'TwigView.Twig_Extension_Ago');
App::import('Lib', 'TwigView.Twig_Extension_Basic');
App::import('Lib', 'TwigView.Twig_Extension_Number');

// get twig core extension (overwrite trans block)
App::import('Lib', 'TwigView.CoreExtension');

/**
 * TwigView for CakePHP
 * 
 * @version 0.5
 * @author Kjell Bublitz <m3nt0r.de@gmail.com>
 * @link http://github.com/m3nt0r/cakephp-twig-view GitHub
 * @package app.views
 * @subpackage app.views.twig
 */
class TwigView extends View {

	/**
	 * File extension
	 *
	 * @var string
	 */
	public $ext = '.tpl';
	
	/**
	 * Twig Environment Instance
	 * @var Twig_Environment
	 */
	public $Twig;
	
	/**
	 * Collection of paths. 
	 * These are stripped from $___viewFn.
	 * @todo overwrite getFilename()
	 */
	public $templatePaths = array();
	
	/**
	 * Load Twig
	 */
	public function __construct(Controller $Controller, $register = true) {
		$this->templatePaths = App::path('View');
		$loader = new Twig_Loader_Filesystem($this->templatePaths[0]);
		$this->Twig = new Twig_Environment($loader, array(
			'cache' => TWIG_VIEW_CACHE,
			'charset' => strtolower(Configure::read('App.encoding')),
			'auto_reload' => Configure::read('debug') > 0,
			'autoescape' => false
		));;
		
		$this->Twig->addExtension(new CoreExtension);
		$this->Twig->addExtension(new Twig_Extension_I18n);
		$this->Twig->addExtension(new Twig_Extension_Ago);
		$this->Twig->addExtension(new Twig_Extension_Basic);
		$this->Twig->addExtension(new Twig_Extension_Number);
		
		parent::__construct($Controller, $register);
		
		if (isset($Controller->theme)) {
			$this->theme = $Controller->theme;
		}
		$this->ext = '.tpl';
	}
	
	/**
	 * Render Proxy
	 */
	protected function _render($___viewFn, $___dataForView = array()) {
		$isCtpFile = (substr($___viewFn, -3) === 'ctp');
		
		if (empty($___dataForView)) {
			$___dataForView = $this->viewVars;
		}
				
		if ($isCtpFile) {
			$out = parent::_render($___viewFn, $___dataForView);
		} else {
			ob_start();
			// Setup the helpers from the new Helper Collection
			$helpers = array();
			$loaded_helpers = $this->Helpers->attached();
			foreach($loaded_helpers as $helper) {
				$name = Inflector::variable($helper);
				$helpers[$name] =& $this->loadHelper($helper);
			}

			$data = array_merge($___dataForView, $helpers);	
			$data['_view'] = $this;
			
			try {
				$relativeFn = str_replace($this->templatePaths, '', $___viewFn);
				$template = $this->Twig->loadTemplate($relativeFn);
				echo $template->render($data);
			} 
			catch (Twig_SyntaxError $e) {
				$this->displaySyntaxException($e);
			} catch (Twig_RuntimeError $e) {
				$this->displayRuntimeException($e);
			} catch (RuntimeException $e) {
				$this->displayRuntimeException($e);
			} catch (Twig_Error $e) {
				$this->displayException($e, 'Error');
			}
			$out = ob_get_clean();
		}
		
		return $out;
	}

	/**
	 * Element: 2.0
	 */
	function element($name, $params = array(), $callbacks = false) {
		// email hack
		if (substr($name, 0, 5) != 'email') {
			$this->ext = '.ctp'; // not an email, use .ctp
		}
		
		// render and revert to using .tpl
		$return = parent::element($name, $params, $callbacks);
		$this->ext = '.tpl';
		return $return;
	}
	
	/**
	 * I know. There are probably a million better ways, but this works too.
	 */
	private function _exception($type, $content, $message = null) {
		if (Configure::read() > 0) {
			$html = '<html><head><title>'.$type.'.</title></head><body style="font-family:sans-serif">';
			$html.= '<div style="width:70%;margin:20px auto;border:1px solid #aaa;text-align:center;padding: 10px">';
			$html.= '<h1 style="color:#f06">Twig :: '.$type.'</h1>'.$content.'</div></body></html>';
			return $html;
		} else {
			$this->log('[TwigView] '.$type.': '.$message);
			return '';
		}
	}
	private function displaySyntaxException($e) {
		$content = '<h3>'.$e->getFilename().', Line: '.$e->getLine().'</h3>';
		$content.= '<p class="error">'.$e->getMessage().'</p>';
		echo $this->_exception('Syntax Error', $content, $e->getMessage());
	}
	private function displayRuntimeException($e) {
		$content = '<h3>'.$e->getMessage().'</h3>';
		$content.= '<p class="error">'.$e->getFile().', Line: '.$e->getLine().'</p>';
		echo $this->_exception('Runtime Error', $content, $e->getMessage());
	}
	private function displayException($e) {
		$content = '<h3>'.$e->getMessage().'</h3>';
		$content.= '<p class="error">'.$e->getFile().', Line: '.$e->getLine().'</p>';
		echo $this->_exception('Error', $content, $e->getMessage());
	}
}
