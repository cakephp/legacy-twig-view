<?php declare(strict_types=1);
/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use App\View\AppView;
use Cake\Core\Configure;
use Cake\Event\EventManager;
use Twig\Environment;
use WyriHaximus\CakePHP\Tests\TwigView\TestCase;
use WyriHaximus\TwigView\Event\ConstructEvent;
use WyriHaximus\TwigView\Event\EnvironmentConfigEvent;
use WyriHaximus\TwigView\View\TwigView;

/**
 * Class TwigViewTest.
 */
class TwigViewTest extends TestCase
{
    public function testInheritance()
    {
        $this->assertInstanceOf('Cake\View\View', new TwigView());
    }

    public function testConstruct()
    {
        $this->_hibernateListeners(ConstructEvent::EVENT);

        $callbackFired = false;
        $eventCallback = function ($event) use (&$callbackFired) {
            self::assertInstanceof(Environment::class, $event->getSubject()->getTwig());
            $callbackFired = true;
        };
        EventManager::instance()->on(ConstructEvent::EVENT, $eventCallback);

        new TwigView();

        EventManager::instance()->off(ConstructEvent::EVENT, $eventCallback);
        $this->_wakeupListeners(ConstructEvent::EVENT);

        $this->assertTrue($callbackFired);
    }

    public function testConstructConfig()
    {
        Configure::write(TwigView::ENV_CONFIG, [
            'true' => true,
        ]);

        $this->_hibernateListeners(EnvironmentConfigEvent::EVENT);

        $callbackFired = false;
        $that = $this;
        $eventCallback = function ($event) use ($that, &$callbackFired) {
            $that->assertInternalType('array', $event->getConfig());
            $that->assertTrue($event->getConfig()['true']);

            $callbackFired = true;
        };
        EventManager::instance()->on(EnvironmentConfigEvent::EVENT, $eventCallback);

        new TwigView();

        EventManager::instance()->off(EnvironmentConfigEvent::EVENT, $eventCallback);
        $this->_wakeupListeners(EnvironmentConfigEvent::EVENT);

        $this->assertTrue($callbackFired);
    }

    public function test_renderCtp()
    {
        $output = 'foo:bar with a beer';

        $twig = Phake::mock('Twig_Environment');

        $view = Phake::partialMock('WyriHaximus\TwigView\View\TwigView');
        Phake::when($view)->getTwig()->thenReturn($twig);

        $this->assertSame(
            $output,
            self::getMethod('_render')->invokeArgs(
                $view,
                [
                    PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Template' . DS . 'cakephp.ctp',
                ]
            )
        );
    }

    public function test_renderTpl()
    {
        $output = 'foo:bar with a beer';

        $template = Phake::mock('Twig_Template');

        $twig = Phake::mock('Twig_Environment');
        Phake::when($twig)->loadTemplate('foo.tpl')->thenReturn($template);

        $view = Phake::partialMock('WyriHaximus\TwigView\View\TwigView');
        Phake::when($view)->getTwig()->thenReturn($twig);
        Phake::when($template)->render(
            [
                '_view' => $view,
            ]
        )->thenReturn($output);

        $this->assertSame(
            $output,
            self::getMethod('_render')->invokeArgs(
                $view,
                [
                    'foo.tpl',
                ]
            )
        );
    }

    /**
     * Tests that a twig file that throws a custom exception correctly renders the thrown exception and not a Twig one.
     *
     * @expectedException App\Exception\MissingSomethingException
     */
    public function test_renderTwigCustomException()
    {
        $view = new AppView();
        $view->setLayout(false);
        $view->render('exception');
    }

    /**
     * Tests that a twig file that throws a Twig exception correctly throws the twig exception and does not get caught
     * byt the modification.
     *
     * @expectedException Twig_Error_Syntax
     */
    public function test_renderTwigTwigException()
    {
        $view = new AppView();
        $view->setLayout(false);
        $view->render('syntaxerror');
    }

    /**
     * @param $name
     * @return ReflectionMethod
     */
    protected static function getMethod($name)
    {
        $class = new ReflectionClass('WyriHaximus\TwigView\View\TwigView');
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * @param $name
     * @return ReflectionProperty
     */
    protected static function getProperty($name)
    {
        $class = new ReflectionClass('WyriHaximus\TwigView\View\TwigView');
        $property = $class->getProperty($name);
        $property->setAccessible(true);

        return $property;
    }

    protected function _hibernateListeners($eventKey)
    {
        $this->__preservedEventListeners[$eventKey] = EventManager::instance()->listeners($eventKey);

        foreach ($this->__preservedEventListeners[$eventKey] as $eventListener) {
            EventManager::instance()->off($eventListener['callable'], $eventKey);
        }
    }

    protected function _wakeupListeners($eventKey)
    {
        if (isset($this->__preservedEventListeners[$eventKey])) {
            return;
        }

        foreach ($this->__preservedEventListeners[$eventKey] as $eventListener) {
            EventManager::instance()->on(
                $eventListener['callable'],
                $eventKey,
                [
                    'passParams' => $eventListener['passParams'],
                ]
            );
        }

        $this->__preservedEventListeners = [];
    }
}
