<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\CakePHP\Tests\TwigView\Event;

use Cake\TestSuite\TestCase;
use WyriHaximus\TwigView\Event\ConstructEvent;

class ConstructEventTest extends TestCase
{
    public function testCreate()
    {
        $twigView        = \Phake::mock('WyriHaximus\TwigView\View\TwigView');
        $twigEnvironment = \Phake::mock('Twig_Environment');
        $event           = ConstructEvent::create($twigView, $twigEnvironment);

        $this->assertEquals($twigView, $event->getTwigView());
        $this->assertEquals($twigEnvironment, $event->getTwig());
    }
}
