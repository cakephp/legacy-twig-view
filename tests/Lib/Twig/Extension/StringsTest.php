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

    public function testInsert()
    {
        $string = ':name is :age years old.';
        $keyValues = ['name' => 'Bob', 'age' => '65'];
        $callable = $this->getFilter('insert')->getCallable();
        $result = call_user_func_array($callable, [$string, $keyValues]);
        $this->assertSame('Bob is 65 years old.', $result);
    }

    public function testCleanInsert()
    {
        $input = 'Bob is 65 years old.';
        $callable = $this->getFilter('cleanInsert')->getCallable();
        $result = call_user_func_array($callable, [$input, ['clean' => false]]);
        $this->assertSame('Bob is 65 years old.', $result);
    }

    public function testWrap()
    {
        $input = 'Bob is 65 years old.';
        $callable = $this->getFilter('wrap')->getCallable();
        $result = call_user_func_array($callable, [$input, ['width' => 2]]);
        $this->assertSame("Bob\nis\n65\nyears\nold.", $result);
    }

    public function testWrapBlock()
    {
        $input = 'Bob is 65 years old.';
        $callable = $this->getFilter('wrapBlock')->getCallable();
        $result = call_user_func_array($callable, [$input, ['width' => 2]]);
        $this->assertSame("Bob\nis\n65\nyears\nold.", $result);
    }

    public function testWordWrap()
    {
        $input = "Bob is\n65 years old.";
        $callable = $this->getFilter('wordWrap')->getCallable();
        $result = call_user_func_array($callable, [$input, 2]);
        $this->assertSame("Bob\nis\n65\nyears\nold.", $result);
    }

    public function testHighlight()
    {
        $input = 'Bob is 65 years old.';
        $callable = $this->getFilter('highlight')->getCallable();
        $result = call_user_func_array($callable, [$input, 'Bob']);
        $this->assertSame('<span class="highlight">Bob</span> is 65 years old.', $result);
    }

    public function testTail()
    {
        $input = 'Bob is 65 years old.';
        $callable = $this->getFilter('tail')->getCallable();
        $result = call_user_func_array($callable, [$input, 7]);
        $this->assertSame('...old.', $result);
    }

    public function testTruncate()
    {
        $input = 'Bob is 65 years old.';
        $callable = $this->getFilter('truncate')->getCallable();
        $result = call_user_func_array($callable, [$input, 7]);
        $this->assertSame('Bob ...', $result);
    }

    public function testExcerpt()
    {
        $input = 'Bob is 65 years old.';
        $callable = $this->getFilter('excerpt')->getCallable();
        $result = call_user_func_array($callable, [$input, '65', 4]);
        $this->assertSame('... is 65 yea...', $result);
    }

    public function testToList()
    {
        $input = ['a', 'b', 'c'];
        $callable = $this->getFilter('toList')->getCallable();
        $result = call_user_func_array($callable, [$input]);
        $this->assertSame('a, b and c', $result);
    }

    public function testStripLinks()
    {
        $input = 'no link, <a href="https://example.com">a link</a>';
        $callable = $this->getFilter('stripLinks')->getCallable();
        $result = call_user_func_array($callable, [$input]);
        $this->assertSame('no link, a link', $result);
    }

    public function testIsMultibyte()
    {
        $input = chr(133);
        $callable = $this->getFilter('isMultibyte')->getCallable();
        $result = call_user_func_array($callable, [$input]);
        $this->assertSame(true, $result);
    }
}
