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

namespace Cake\TwigView\Test\Event;

use Cake\TwigView\Event\ConstructEvent;
use Cake\TwigView\Test\TestCase;
use Cake\TwigView\View\TwigView;
use Twig\Environment;

class ConstructEventTest extends TestCase
{
    public function testCreate()
    {
        $twigView = $this->prophesize(TwigView::class)->reveal();
        $twigEnvironment = $this->prophesize(Environment::class)->reveal();
        $event = ConstructEvent::create($twigView, $twigEnvironment);

        $this->assertEquals($twigView, $event->getTwigView());
        $this->assertEquals($twigEnvironment, $event->getTwig());
    }
}
