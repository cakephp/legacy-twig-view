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
	define('TWIG_VIEW_CACHE', APP.'plugins'.DS.'twig_view'.DS.'tmp'.DS.'views');
}

// Load Twig Lib and start auto loader
App::import('Vendor', 'TwigView.TwigAutoloader', array(
	'file' => 'Twig'.DS.'lib'.DS.'Twig'.DS.'Autoloader.php'
));
Twig_Autoloader::register();

// overwrite twig classes (thanks to autoload, no problem)
App::import('Lib', 'TwigView.TransNode');
App::import('Lib', 'TwigView.TokenparserTrans');

// my custom cake extensions
App::import('Lib', 'TwigView.ExtensionI18n');
App::import('Lib', 'TwigView.ExtensionAgo');
App::import('Lib', 'TwigView.ExtensionBasic');
App::import('Lib', 'TwigView.ExtensionNumbers');

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
			'cache' => TWIG_VIEW_CACHE,
			'charset' => strtolower(Configure::read('App.encoding')),
			'auto_reload' => (bool) Configure::read('debug'),
			'autoescape' => false
		));;
		
		// overwrite some stuff
		$this->Twig->addExtension(new CoreExtension);
		
		// activate |trans filter
		$this->Twig->addExtension(new Twig_Extension_I18n);
		
		// activate |ago filter
		$this->Twig->addExtension(new Twig_Extension_TimeAgo);
		
		// activate basic filter
		$this->Twig->addExtension(new Twig_Extension_Basic);
		
		// activate number filters
		$this->Twig->addExtension(new Twig_Extension_Number);
		
		parent::__construct($controller, $register);
		
		if (isset($controller->theme))
			$this->theme =& $controller->theme;
			
		$this->ext = '.tpl';
	}
	
	/**
	 * Feature Detection
	 */
	private function isCake2() {
		return (isset($this->Helpers) && method_exists($this->Helpers, 'attached'));
	}
	
	/**
	 * Render Proxy
	 */
	function _render($___viewFn, $___dataForView = array(), $loadHelpers = true) {
		if ($this->isCake2()) {
			return $this->_render2x($___viewFn, $___dataForView);
	 	} else {
			return $this->_render1x($___viewFn, $___dataForView, $loadHelpers = true);
		}
	}
	
	/**
	 * Render: 2.0
	 *
	 * Thanks to BigClick
	 * @link https://github.com/bigclick/cakephp-twig-view/commit/2e3e0aa65d3ac6e492f441cd6196c524087c5e95
	 */
	protected function _render2x($___viewFn, $___dataForView = array()) {
		
		$isCtpFile = (substr($___viewFn, -3) == 'ctp');
		
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
	 * Render: 1.2+
	 */
	function _render1x($___viewFn, $___dataForView, $loadHelpers = true) {
		$loadedHelpers = array();
		
		if ($this->helpers != false && $loadHelpers === true) {
			$loadedHelpers = $this->_loadHelpers($loadedHelpers, $this->helpers);
			$helpers = array_keys($loadedHelpers);
			$helperNames = array_map(array('Inflector', 'variable'), $helpers);

			for ($i = count($helpers) - 1; $i >= 0; $i--) {
				$name = $helperNames[$i];
				$helper =& $loadedHelpers[$helpers[$i]];

				if (!isset($___dataForView[$name])) {
					${$name} =& $helper;
				}
				$this->loaded[$helperNames[$i]] =& $helper;
				$this->{$helpers[$i]} =& $helper;
			}
			$this->_triggerHelpers('beforeRender');
			unset($name, $loadedHelpers, $helpers, $i, $helperNames);
		}
		
		$isCtpFile = (substr($___viewFn, -3) == 'ctp');
		
		ob_start();
		
		if ($isCtpFile) {
			extract($___dataForView, EXTR_SKIP);
			if (Configure::read() > 0) {
				include ($___viewFn);
			} else {
				@include ($___viewFn);
			}
		} else {			
			$data = array_merge($___dataForView, $this->loaded);
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
		}
		if ($loadHelpers === true) {
			$this->_triggerHelpers('afterRender');
		}
		
		$out = ob_get_clean();
		
		if ($isCtpFile) {
			$caching = (
				isset($this->loaded['cache']) &&
				(($this->cacheAction != false)) && (Configure::read('Cache.check') === true)
			);
			if ($caching) {
				if (is_a($this->loaded['cache'], 'CacheHelper')) {
					$cache =& $this->loaded['cache'];
					$cache->base = $this->base;
					$cache->here = $this->here;
					$cache->helpers = $this->helpers;
					$cache->action = $this->action;
					$cache->controllerName = $this->name;
					$cache->layout = $this->layout;
					$cache->cacheAction = $this->cacheAction;
					$cache->cache($___viewFn, $out, $cached);
				}
			}
		}
		return $out;
	}
	
	/**
	 * Element: 1.2+
	 */
	function element1x($name, $params = array(), $loadHelpers = false) {
		// render and revert to using .tpl
		$return = parent::element($name, $params, $loadHelpers);
		$this->ext = '.tpl';
		return $return;
	}
	
	/**
	 * Element: 2.0
	 */
	function element2x($name, $params = array(), $callbacks = false) {
		// render and revert to using .tpl
		$return = parent::element($name, $params, $callbacks);
		$this->ext = '.tpl';
		return $return;
	}
	
	/**
	 * Element Proxy
	 *
	 * Support for cake 2.0
	 */
	public function element($name, $params = array(), $callbacks = false) {
		// email hack
		if (substr($name, 0, 5) != 'email') {
			$this->ext = '.ctp'; // not an email, use .ctp
		}
		
		if ($this->isCake2()) {
			return $this->element2x($name, $params, $callbacks);
		} else {
			return $this->element1x($name, $params, $callbacks);
		}
	}

	/**
	 * Return all possible paths to find view files in order
	 * 
	 * Added to TwigView
	 *   - super hard copy-paste job from /cake/libs/view/theme.php :)
	 *   - added "isset" test: fallback to default behavior.
	 *
	 * @param string $plugin The name of the plugin views are being found for.
	 * @param boolean $cached Set to true to force dir scan.
	 * @return array paths
	 * @access protected
	 * @todo Make theme path building respect $cached parameter.
	 */
	function _paths($plugin = null, $cached = true) {
		if (!isset($this->theme)) {
			return parent::_paths($plugin, $cached);
		}
		
		$paths = parent::_paths($plugin, $cached);
		$themePaths = array();

		if (!empty($this->theme)) {
			$count = count($paths);
			for ($i = 0; $i < $count; $i++) {
				if (strpos($paths[$i], DS . 'plugins' . DS) === false
					&& strpos($paths[$i], DS . 'libs' . DS . 'view') === false) {
						if ($plugin) {
							$themePaths[] = $paths[$i] . 'themed'. DS . $this->theme . DS . 'plugins' . DS . $plugin . DS;
						}
						$themePaths[] = $paths[$i] . 'themed'. DS . $this->theme . DS;
					}
			}
			$paths = array_merge($themePaths, $paths);
		}
		return $paths;
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
