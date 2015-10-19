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
use Cake\Event\EventManager;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\View\View;
use WyriHaximus\TwigView\Event\ConstructEvent;
use WyriHaximus\TwigView\Event\LoaderEvent;
use WyriHaximus\TwigView\Lib\Twig\Loader;

/**
 * Class TwigView
 * @package WyriHaximus\TwigView\View
 */
// @codingStandardsIgnoreStart
class TwigView extends View
// @codingStandardsIgnoreEnd
{

    const EXT = '.tpl';

    /**
     * Extension to use.
     *
     * @var string
     */
    // @codingStandardsIgnoreStart
    protected $_ext = self::EXT;
    // @codingStandardsIgnoreEnd

    /**
     * Twig instance.
     *
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * Helpers.
     *
     * @var array
     */
    protected $helperList = [];

    /**
     * Event manager.
     *
     * @var EventManager
     */
    protected $eventManager;

    /**
     * Constructor.
     *
     * @param Request      $request      Request.
     * @param Response     $response     Response.
     * @param EventManager $eventManager EventManager.
     * @param array        $viewOptions  View options.
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

        $this->eventManager->dispatch(ConstructEvent::create($this, $this->twig));

        parent::__construct($request, $response, $eventManager, $viewOptions);
        $this->_ext = self::EXT;

        $this->generateHelperList();
    }

    /**
     * Create the template loader.
     *
     * @return \Twig_LoaderInterface
     */
    protected function getLoader()
    {
        $event = LoaderEvent::create(new Loader());
        $this->eventManager->dispatch($event);
        return $event->getResultLoader();
    }

    /**
     * Create a useful helper list.
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
     * Render the template.
     *
     * @param string $viewFile Template file.
     * @param array  $data     Data that can be used by the template.
     *
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
            // @codingStandardsIgnoreStart
        } else {
            // @codingStandardsIgnoreEnd
            $data = array_merge(
                $data,
                $this->helperList,
                [
                    '_view' => $this,
                ]
            );
            // @codingStandardsIgnoreStart
            $out = $this->getTwig()->loadTemplate($viewFile)->render($data);
            // @codingStandardsIgnoreEnd
        }

        return $out;
    }

    /**
     * Get twig environment instance.
     *
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }
}
