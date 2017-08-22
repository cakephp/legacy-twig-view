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

use WyriHaximus\TwigView\Lib\Twig\Extension\Strings;

final class StringsTest extends AbstractExtensionTest
{
    public function setUp()
    {
        $this->extension = new Strings();
        parent::setUp();
    }

    public function testSubstr()
    {
        $string = 'abc';
        $callable = $this->getFilter('substr')->getCallable();
        $result = call_user_func_array($callable, [$string, -1]);
        $this->assertSame('c', $result);
    }

    public function testTokenize()
    {
        $string = 'a,b,c';
        $callable = $this->getFilter('tokenize')->getCallable();
        $result = call_user_func_array($callable, [$string]);
        $this->assertSame(['a', 'b', 'c'], $result);
    }
}
