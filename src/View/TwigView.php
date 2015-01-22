<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\TwigView\View;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\View\View;
use WyriHaximus\TwigView\Lib\Twig\Loader;

/**
 * Class TwigView
 * @package WyriHaximus\TwigView\View
 */
class TwigView extends View
{

    const EXT = '.tpl';

    /**
     * @var string
     */
    protected $ext = self::EXT;

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
     * @var \Cake\Event\EventManager
     */
    protected $eventManager;

    /**
     * Constructor
     *
     * @param Request $request Request
     * @param Response $response Response
     * @param EventManager $eventManager EventManager
     * @param array $viewOptions View options
     */
    public function __construct(
        Request $request = null,
        Response $response = null,
        EventManager $eventManager = null,
        array $viewOptions = []
    ) {
        if ($eventManager === null) {
            $eventManager = EventManager::instance();
        }
        $this->eventManager = $eventManager;

        $this->twig = new \Twig_Environment($this->getLoader(), [
            'cache' => CACHE . 'twigView' . DS,
            'charset' => strtolower(Configure::read('App.encoding')),
            'auto_reload' => Configure::read('debug'),
            'debug' => Configure::read('debug')
        ]);

        $this->eventManager->dispatch(new Event('TwigView.TwigView.construct', $this));

        parent::__construct($request, $response, $eventManager, $viewOptions);
        $this->ext = self::EXT;

        $this->generateHelperList();
    }

    /**
     * Create Loader
     *
     * @return \Twig_LoaderInterface
     */
    protected function getLoader()
    {
        $event = new Event('TwigView.TwigView.loader', $this, [
            'loader' => new Loader(),
        ]);
        $this->eventManager->dispatch($event);

        if (isset($event->result['loader'])) {
            return $event->result['loader'];
        }

        return $event->data['loader'];
    }

    /**
     * Create a useful helper list
     *
     * @return void
     */
    protected function generateHelperList()
    {
        $registry = $this->helpers();
        $helpers = $registry->normalizeArray($this->helpers);
        foreach ($helpers as $properties) {
            list(, $class) = pluginSplit($properties['class']);
            $this->helperList[$class] = $this->{$class};
        }
    }

    /**
     * Render the template
     *
     * @param string $viewFile Template
     * @param array $data Data
     * @return string
     */
    // @codingStandardsIgnoreStart
    protected function _render($viewFile, $data = array())
    {
        // @codingStandardsIgnoreEnd
        if (empty($data)) {
            $data = $this->viewVars;
        }

        if (substr($viewFile, -3) === 'ctp') {
            $out = parent::_render($viewFile, $data);
        } else {
            $data = array_merge(
                $data,
                $this->helperList,
                [
                    '_view' => $this,
                ]
            );
            $out = $this->getTwig()->loadTemplate($viewFile)->render($data);
        }

        return $out;
    }

    /**
     * Get twig environment instance
     *
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }
}
