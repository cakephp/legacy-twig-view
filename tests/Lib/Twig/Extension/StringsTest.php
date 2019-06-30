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

namespace WyriHaximus\CakePHP\Tests\TwigView\Lib\Twig\Extension;

use WyriHaximus\TwigView\Lib\Twig\Extension\Strings;

final class StringsTest extends AbstractExtensionTest
{
    public function setUp(): void
    {
        $this->extension = new Strings();
        parent::setUp();
    }

    public function testFilterSubstr()
    {
        $string = 'abc';
        $callable = $this->getFilter('substr')->getCallable();
        $result = call_user_func_array($callable, [$string, -1]);
        $this->assertSame('c', $result);
    }

    public function testFilterTokenize()
    {
        $string = 'a,b,c';
        $callable = $this->getFilter('tokenize')->getCallable();
        $result = call_user_func_array($callable, [$string]);
        $this->assertSame(['a', 'b', 'c'], $result);
    }

    public function testFilterInsert()
    {
        $string = ':name is :age years old.';
        $keyValues = ['name' => 'Bob', 'age' => '65'];
        $callable = $this->getFilter('insert')->getCallable();
        $result = call_user_func_array($callable, [$string, $keyValues]);
        $this->assertSame('Bob is 65 years old.', $result);
    }

    public function testFilterCleanInsert()
    {
        $input = 'Bob is 65 years old.';
        $callable = $this->getFilter('cleanInsert')->getCallable();
        $result = call_user_func_array($callable, [$input, ['clean' => false]]);
        $this->assertSame('Bob is 65 years old.', $result);
    }

    public function testFilterWrap()
    {
        $input = 'Bob is 65 years old.';
        $callable = $this->getFilter('wrap')->getCallable();
        $result = call_user_func_array($callable, [$input, ['width' => 2]]);
        $this->assertSame("Bob\nis\n65\nyears\nold.", $result);
    }

    public function testFilterWrapBlock()
    {
        $input = 'Bob is 65 years old.';
        $callable = $this->getFilter('wrapBlock')->getCallable();
        $result = call_user_func_array($callable, [$input, ['width' => 2]]);
        $this->assertSame("Bob\nis\n65\nyears\nold.", $result);
    }

    public function testFilterWordWrap()
    {
        $input = "Bob is\n65 years old.";
        $callable = $this->getFilter('wordWrap')->getCallable();
        $result = call_user_func_array($callable, [$input, 2]);
        $this->assertSame("Bob\nis\n65\nyears\nold.", $result);
    }

    public function testFilterHighlight()
    {
        $input = 'Bob is 65 years old.';
        $callable = $this->getFilter('highlight')->getCallable();
        $result = call_user_func_array($callable, [$input, 'Bob']);
        $this->assertSame('<span class="highlight">Bob</span> is 65 years old.', $result);
    }

    public function testFilterTail()
    {
        $input = 'Bob is 65 years old.';
        $callable = $this->getFilter('tail')->getCallable();
        $result = call_user_func_array($callable, [$input, 7]);
        $this->assertSame('...old.', $result);
    }

    public function testFilterTruncate()
    {
        $input = 'Bob is 65 years old.';
        $callable = $this->getFilter('truncate')->getCallable();
        $result = call_user_func_array($callable, [$input, 7]);
        $this->assertSame('Bob ...', $result);
    }

    public function testFilterExcerpt()
    {
        $input = 'Bob is 65 years old.';
        $callable = $this->getFilter('excerpt')->getCallable();
        $result = call_user_func_array($callable, [$input, '65', 4]);
        $this->assertSame('... is 65 yea...', $result);
    }

    public function testFilterToList()
    {
        $input = ['a', 'b', 'c'];
        $callable = $this->getFilter('toList')->getCallable();
        $result = call_user_func_array($callable, [$input]);
        $this->assertSame('a, b and c', $result);
    }

    public function testFilterIsMultibyte()
    {
        $input = chr(133);
        $callable = $this->getFilter('isMultibyte')->getCallable();
        $result = call_user_func_array($callable, [$input]);
        $this->assertSame(true, $result);
    }

    public function testFilterUtf8()
    {
        $input = 'É';
        $callable = $this->getFilter('utf8')->getCallable();
        $result = call_user_func_array($callable, [$input]);
        $this->assertSame([201], $result);
    }

    public function testFilterAscii()
    {
        $input = [201];
        $callable = $this->getFilter('ascii')->getCallable();
        $result = call_user_func_array($callable, [$input]);
        $this->assertSame('É', $result);
    }

    public function testParseFileSize()
    {
        $input = '133.780486GB';
        $callable = $this->getFilter('parseFileSize')->getCallable();
        $result = call_user_func_array($callable, [$input]);
        $this->assertSame(143645703053, $result);
    }

    public function testFilterNone()
    {
        $input = 'Bob is 65 years old.';
        $callable = $this->getFilter('none')->getCallable();
        $result = call_user_func_array($callable, [$input]);
        $this->assertSame(null, $result);
    }

    public function testFunctionUuid()
    {
        $callable = $this->getFunction('uuid')->getCallable();
        $result = call_user_func($callable);
        $this->assertInternalType('string', $result);
        $this->assertSame(36, strlen($result));
    }
}
