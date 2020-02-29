<?php
declare(strict_types=1);

/**
 * This file is part of TwigView.
 *
 ** (c) 2015 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cake\TwigView\Test\Lib\Twig\Extension;

use Cake\TwigView\Lib\Twig\Extension\Basic;

final class BasicTest extends AbstractExtensionTest
{
    public function setUp(): void
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

    public function testFilterPr()
    {
        $string = 'abc';
        $callable = $this->getFilter('pr')->getCallable();
        ob_start();
        $result = call_user_func_array($callable, [$string]);
        $output = ob_get_clean();
        $this->assertSame('abc', $result);
        $this->assertSame('
abc

', $output);
    }

    public function testFilterCount()
    {
        $array = ['a', 'b', 'c'];
        $callable = $this->getFilter('count')->getCallable();
        $result = call_user_func_array($callable, [$array]);
        $this->assertSame(3, $result);
    }
}
