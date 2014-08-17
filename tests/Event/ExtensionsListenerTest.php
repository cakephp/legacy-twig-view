<?php


namespace WyriHaximus\CakePHP\Tests\TwigView\Event;

use Cake\TestSuite\TestCase;
use Phake;
use WyriHaximus\CakePHP\TwigView\Event\ExtensionsListener;

/**
 * Class ExtensionsListenerTest
 * @package WyriHaximus\CakePHP\Tests\TwigView\Event
 */
class ExtensionsListenerTest extends TestCase {

    public function testImplementedEvents() {
        $eventsList = (new ExtensionsListener)->implementedEvents();
        $this->assertInternalType('array', $eventsList);
        $this->assertSame(1, count($eventsList));
    }

    public function testConstruct() {
        $twig = Phake::mock('\Twig_Environment');

        $twigView = Phake::mock('WyriHaximus\CakePHP\TwigView\View\TwigView');
        Phake::when($twigView)->getTwig()->thenReturn($twig);

        $event = Phake::mock('Cake\Event\Event');
        Phake::when($event)->subject()->thenReturn($twigView);

        (new ExtensionsListener)->construct($event);

        Phake::verify($twig, Phake::atLeast(1))->addExtension($this->isInstanceOf('\Twig_Extension'));
    }

}