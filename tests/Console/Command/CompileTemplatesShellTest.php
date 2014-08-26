<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\CakePHP\Tests\TwigView\Console\Command;

use Cake\TestSuite\TestCase;
use Phake;
use WyriHaximus\PHPUnit\Helpers\ReflectionTrait;
use WyriHaximus\TwigView\Console\Command\CompileTemplatesShell;

/**
 * Class CompileTemplatesShell
 * @package WyriHaximus\TwigView\Console\Command
 */
class CompileTemplatesShellTest extends TestCase
{

	use ReflectionTrait;

	public function testAll()
	{
		$shell = Phake::mock('WyriHaximus\TwigView\Console\Command\CompileTemplatesShell');
		Phake::when($shell)->all()->thenCallParent();

		$shell->all();

		Phake::verify($shell)->processPlugin('TwigView');
	}

	public function testPlugin()
	{
		$shell = Phake::mock('WyriHaximus\TwigView\Console\Command\CompileTemplatesShell');
		Phake::when($shell)->plugin('bar:foo')->thenCallParent();

		$shell->plugin('bar:foo');

		Phake::verify($shell)->processPlugin('bar:foo');
	}

	public function testFile()
	{
		$shell = Phake::mock('WyriHaximus\TwigView\Console\Command\CompileTemplatesShell');
		Phake::when($shell)->file('foo:bar')->thenCallParent();

		$shell->file('foo:bar');

		Phake::verify($shell)->compileTemplate('foo:bar');
	}

	public function testGetOptionParser()
	{
		$this->assertInstanceOf('\Cake\Console\ConsoleOptionParser', (new CompileTemplatesShell())->getOptionParser());
	}

	public function _testProcessPlugin()
	{
		$iterator = Phake::mock('Iterator');
		$shell = Phake::mock('WyriHaximus\TwigView\Console\Command\CompileTemplatesShell');
		Phake::when($shell)->setupIterator('TwigView')->thenReturn($iterator);
		Phake::when($shell)->walkIterator($iterator)->thenReturn();

		self::getMethod('WyriHaximus\TwigView\Console\Command\CompileTemplatesShell', 'processPlugin')->invokeArgs(
			$shell,
			[
				'TwigView',
			]
		);

		Phake::inOrder(
			Phake::verify($shell)->setupIterator('TwigView'),
			Phake::verify($shell)->walkIterator($iterator)
		);
	}

	public function _testSetupIterator()
	{
		$this->assertInstanceOf('Iterator', (new CompileTemplatesShell())->_setupIterator('TwigView'));
	}

	public function _testWalkIterator()
	{
		//
	}

	public function testCompileTemplate()
	{
		$twig = Phake::mock('Twig_Environment');

		$twigView = Phake::mock('WyriHaximus\TwigView\View\TwigView');
		Phake::when($twigView)->getTwig()->thenReturn($twig);

		$shell = new CompileTemplatesShell();
		$shell->setTwigview($twigView);
	}
}
