<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2015 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\CakePHP\Tests\TwigView\Panel;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use WyriHaximus\TwigView\Lib\Scanner;
use WyriHaximus\TwigView\Panel\TwigPanel;

class TwigPanelTest extends TestCase
{
    public function testData()
    {
        $this->assertSame(Scanner::all(), (new TwigPanel())->data());
    }
}
