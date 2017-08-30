<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2015 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\CakePHP\Tests\TwigView\Lib\Twig\Extension;

use WyriHaximus\TwigView\Lib\Twig\Extension\Basic;

final class BasicTest extends AbstractExtensionTest
{
    public function setUp()
    {
        $this->extension = new Basic();
        parent::setUp();
    }

    public function testFilterDebug()
    {
        $string = 'abc';
        $callable = $this->getFilter('debug')->getCallable();
        ob_start();
        $result = call_user_func_array($callable, [$string, null, false]);
        $output = ob_get_clean();
        $this->assertSame('abc', $result);
        $this->assertSame('
########## DEBUG ##########
\'abc\'
###########################
', $output);
    }
}
