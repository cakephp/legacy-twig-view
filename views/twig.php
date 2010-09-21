<?php
/**
 * TwigView for CakePHP
 *
 * About Twig
 *  http://www.twig-project.org/
 *
 * @package app.views
 * @subpackage app.views.twig
 * @author Kjell Bublitz <m3nt0r.de@gmail.com>
 * @link http://github.com/m3nt0r My GitHub
 * @link http://twitter.com/m3nt0r My Twitter
 * @license MIT License
 */
App::import('Vendor', 'TwigView.TwigAutoloader', array(
	'file' => 'Twig'.DS.'lib'.DS.'Twig'.DS.'Autoloader.php'
));
Twig_Autoloader::register();

// overwrite twig classes (thanks to autoload, no problem)
App::import('Lib', 'TwigView.TransNode');
App::import('Lib', 'TwigView.ExtensionI18n');

/**
 * TwigView for CakePHP
 * 
 * @version 0.3
 * @author Kjell Bublitz <m3nt0r.de@gmail.com>
 * @link http://github.com/m3nt0r/cakephp-twig-view GitHub
 * @package app.views
 * @subpackage app.views.twig
 */
class TwigView extends View {
	
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
	function __construct(&$controller, $register = true) {
		
		// just collecting for str_replace
		$this->templatePaths = array(
			APP.'views',
			ROOT.DS.'cake'.DS.'libs'.DS.'view'
		);
		
		// we always look in APP, this includes error templates.
		$loader = new Twig_Loader_Filesystem(APP.'views');
		
		// setup twig and go.
		$this->Twig = new Twig_Environment($loader, array(
			'cache' => APP.'plugins'.DS.'twig_view'.DS.'tmp'.DS.'views',
			'charset' => strtolower(Configure::read('App.encoding')),
			'auto_reload' => (bool) Configure::read('debug')
		));;
		
		// activate |trans filter
		$this->Twig->addExtension(new Twig_Extension_I18n);
		
		parent::__construct($controller, $register);
		$this->ext = '.tpl';
	}
	
	/**
	 * Overwrite the default _render()
	 */
	function _render($___viewFn, $___dataForView, $loadHelpers = true) {
		$loadedHelpers = array();

		if ($this->helpers != false && $loadHelpers === true) {
			$loadedHelpers = $this->_loadHelpers($loadedHelpers, $this->helpers);
			$helpers = array_keys($loadedHelpers);
			$helperNames = array_map(array('Inflector', 'variable'), $helpers);

			for ($i = count($helpers) - 1; $i >= 0; $i--) {
				$name = $helperNames[$i];
				$this->loaded[$name] =& $loadedHelpers[$helpers[$i]];
			}
			$this->_triggerHelpers('beforeRender');
			unset($name, $loadedHelpers, $helpers, $i, $helperNames);
		}

		// seed helpers
		$data = array_merge($___dataForView, $this->loaded);

		ob_start();
		
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
		
		if ($loadHelpers === true) {
			$this->_triggerHelpers('afterRender');
		}
		
		$out = ob_get_clean();
		
		return $out;
	}
	
	/**
	 * I know. There are probably a million better ways, but this works too.
	 */
	private function _exception($type, $content) {
		$html = '<html><head><title>'.$type.'.</title></head><body style="font-family:sans-serif">';
		$html.= '<div style="width:70%;margin:20px auto;border:1px solid #aaa;text-align:center;padding: 10px">';
		$html.= '<h1 style="color:#f06">Twig :: '.$type.'</h1>'.$content.'</div></body></html>';
		return $html;
	}
	private function displaySyntaxException($e) {
		$content = '<h3>'.$e->getFilename().', Line: '.$e->getLine().'</h3>';
		$content.= '<p class="error">'.$e->getMessage().'</p>';
		echo $this->_exception('Syntax Error', $content);
	}
	private function displayRuntimeException($e) {
		$content = '<h3>'.$e->getMessage().'</h3>';
		$content.= '<p class="error">'.$e->getFile().', Line: '.$e->getLine().'</p>';
		echo $this->_exception('Runtime Error', $content);
	}
}
