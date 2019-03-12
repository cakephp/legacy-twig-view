<?php
declare(strict_types=1);
/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WyriHaximus\CakePHP\Tests\TwigView\Event;

use Twig_Environment;
use WyriHaximus\CakePHP\Tests\TwigView\TestCase;
use WyriHaximus\TwigView\Event\ConstructEvent;
use WyriHaximus\TwigView\View\TwigView;

class ConstructEventTest extends TestCase
{
    public function testCreate()
    {
        $twigView = $this->prophesize(TwigView::class)->reveal();
        $twigEnvironment = $this->prophesize(Twig_Environment::class)->reveal();
        $event = ConstructEvent::create($twigView, $twigEnvironment);

        $this->assertEquals($twigView, $event->getTwigView());
        $this->assertEquals($twigEnvironment, $event->getTwig());
    }
}
