<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\CakePHP\TwigView\View;

use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Core\Configure;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\View\View;
use WyriHaximus\CakePHP\TwigView\Lib\Twig\Loader;

/**
 * Class TwigView
 * @package WyriHaximus\CakePHP\TwigView\View
 */
class TwigView extends View {

    const EXT = '.tpl';

    /**
     * @var string
     */
    protected $_ext = self::EXT;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var array
     */
    protected $helperList = [];

    /**
     * @var
     */
    protected $parentView;

    /**
     * @param Request $request
     * @param Response $response
     * @param EventManager $eventManager
     * @param array $viewOptions
     */
    public function __construct(Request $request = null, Response $response = null,
                                EventManager $eventManager = null, array $viewOptions = []) {
		$this->twig = new \Twig_Environment(new Loader(), [
			'cache' => CACHE . 'twigView' . DS,
			'charset' => strtolower(Configure::read('App.encoding')),
			'auto_reload' => Configure::read('debug'),
			'debug' => Configure::read('debug')
		]);

        if ($eventManager === null) {
            $eventManager = EventManager::instance();
        }

        $eventManager->dispatch(new Event('TwigView.TwigView.construct', $this));

		parent::__construct($request, $response, $eventManager, $viewOptions);
		$this->_ext = self::EXT;

        $this->generateHelperList();
	}

    protected function generateHelperList() {
        $registry = $this->helpers();
        $helpers = $registry->normalizeArray($this->helpers);
        foreach ($helpers as $properties) {
            list(, $class) = pluginSplit($properties['class']);
            $this->helperList[$class] = $this->{$class};
        }
    }

    /**
     * @param string $viewFile
     * @param array $data
     * @return string
     */
    protected function _render($viewFile, $data = array()) {
		if (empty($data)) {
            $data = $this->viewVars;
		}

		if (substr($viewFile, -3) === 'ctp') {
			$out = parent::_render($viewFile, $data);
		} else {
			$data = array_merge($data, $this->helperList, [
                '_view' => $this,
            ]);
            $out = $this->getTwig()->loadTemplate($viewFile)->render($data);
		}

		return $out;
	}

    /**
     * @return \Twig_Environment
     */
    public function getTwig() {
        return $this->twig;
    }
}
