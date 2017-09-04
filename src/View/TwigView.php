<?php declare(strict_types=1);
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
use Exception;
use Twig\Environment as TwigEnvironment;
use WyriHaximus\TwigView\Event\ConstructEvent;
use WyriHaximus\TwigView\Event\EnvironmentConfigEvent;
use WyriHaximus\TwigView\Event\LoaderEvent;
use WyriHaximus\TwigView\Lib\Twig\Loader;

/**
 * Class TwigView.
 * @package WyriHaximus\TwigView\View
 */
class TwigView extends View
{
    const EXT = '.twig';

    const ENV_CONFIG = 'WyriHaximus.TwigView.environment';

    /**
     * Extension to use.
     *
     * @var string
     */
    protected $_ext = self::EXT;

    /**
     * @var array
     */
    protected $extensions = [
        self::EXT,
        '.tpl',
        '.ctp',
    ];

    /**
     * Twig instance.
     *
     * @var \Twig\Environment
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

        $this->twig = new TwigEnvironment($this->getLoader(), $this->resolveConfig());

        $this->eventManager->dispatch(ConstructEvent::create($this, $this->twig));

        parent::__construct($request, $response, $eventManager, $viewOptions);
        $this->_ext = self::EXT;

        $this->generateHelperList();
    }

    /**
     * @param string $extension
     */
    public function unshiftExtension($extension)
    {
        array_unshift($this->extensions, $extension);
    }

    /**
     * Get twig environment instance.
     *
     * @return \Twig\Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
     * @return array
     */
    protected function resolveConfig()
    {
        $charset = 'utf-8';
        if (Configure::read('App.encoding') !== null) {
            $charset = strtolower(Configure::read('App.encoding'));
        }
        $debugFlag = false;
        if (Configure::read('App.encoding') === true) {
            $debugFlag = true;
        }
        $config = [
            'cache' => CACHE . 'twigView' . DS,
            'charset' => $charset,
            'auto_reload' => $debugFlag,
            'debug' => $debugFlag,
        ];

        $config = array_replace($config, $this->readConfig());

        $configEvent = EnvironmentConfigEvent::create($config);
        $this->eventManager->dispatch($configEvent);

        return $configEvent->getConfig();
    }

    /**
     * @return array
     */
    protected function readConfig()
    {
        if (!Configure::check(static::ENV_CONFIG)) {
            return [];
        }

        $config = Configure::read(static::ENV_CONFIG);
        if (!is_array($config)) {
            return [];
        }

        return $config;
    }

    /**
     * Create the template loader.
     *
     * @return \Twig\Loader\LoaderInterface
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
     */
    protected function generateHelperList()
    {
        $registry = $this->helpers();

        $helpersList = array_merge($this->helpers, $registry->loaded());
        $helpers = $registry->normalizeArray($helpersList);
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
     * @throws \Exception
     * @return string
     */
    protected function _render($viewFile, $data = [])
    {
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

            try {
                $out = $this->getTwig()->loadTemplate($viewFile)->render($data);
            } catch (Exception $e) {
                $previous = $e->getPrevious();

                if ($previous !== null && $previous instanceof Exception) {
                    throw $previous;
                } else {
                    throw $e;
                }
            }
        }

        return $out;
    }

    /**
     * @param  string|null $name
     * @throws \Exception
     * @return string
     */
    protected function _getViewFileName($name = null)
    {
        $rethrow = new \Exception('You\'re not supposed to get here');
        foreach ($this->extensions as $extension) {
            $this->_ext = $extension;
            try {
                return parent::_getViewFileName($name);
            } catch (\Exception $exception) {
                $rethrow = $exception;
            }
        }

        throw $rethrow;
    }

    /**
     * @param  string|null $name
     * @throws \Exception
     * @return string
     */
    protected function _getLayoutFileName($name = null)
    {
        $rethrow = new \Exception('You\'re not supposed to get here');
        foreach ($this->extensions as $extension) {
            $this->_ext = $extension;
            try {
                return parent::_getLayoutFileName($name);
            } catch (\Exception $exception) {
                $rethrow = $exception;
            }
        }

        throw $rethrow;
    }

    /**
     * @param  string     $name
     * @param  bool       $pluginCheck
     * @throws \Exception
     * @return string
     */
    protected function _getElementFileName($name, $pluginCheck = true)
    {
        foreach ($this->extensions as $extension) {
            $this->_ext = $extension;
            $result = parent::_getElementFileName($name, $pluginCheck);
            if ($result !== false) {
                return $result;
            }
        }

        return false;
    }
}
