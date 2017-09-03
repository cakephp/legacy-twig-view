<?php declare(strict_types=1);
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
use WyriHaximus\TwigView\Event\LoaderEvent;
use WyriHaximus\TwigView\Lib\Twig\Loader;

class LoaderEventTest extends TestCase
{
    public function testArrayResultLoader()
    {
        $loader = new Loader();
        $loader2 = \Phake::mock('Twig_LoaderInterface');
        $event = LoaderEvent::create($loader);
        $event->result = [
            'loader' => $loader2,
        ];
        $this->assertEquals($loader2, $event->getResultLoader());
    }

    public function testResultLoader()
    {
        $loader = new Loader();
        $loader2 = \Phake::mock('Twig_LoaderInterface');
        $event = LoaderEvent::create($loader);
        $event->result = $loader2;
        $this->assertEquals($loader2, $event->getResultLoader());
    }

    public function testLoader()
    {
        $loader = new Loader();
        $event = LoaderEvent::create($loader);
        $this->assertEquals($loader, $event->getResultLoader());
    }
}
