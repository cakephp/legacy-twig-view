<?php declare(strict_types=1);
/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WyriHaximus\CakePHP\Tests\TwigView\Shell;

use Cake\TestSuite\TestCase;
use Phake;
use WyriHaximus\PHPUnit\Helpers\ReflectionTrait;
use WyriHaximus\TwigView\Shell\CompileShell;

/**
 * Class CompileShell.
 * @package WyriHaximus\TwigView\Shell
 */
class CompileShellTest extends TestCase
{
    use ReflectionTrait;

    public function testAll()
    {
        $shell = Phake::mock('WyriHaximus\TwigView\Shell\CompileShell');
        Phake::when($shell)->all()->thenCallParent();

        $shell->all();
    }

    /**
     * @expectedException Exception
     */
    public function testPlugin()
    {
        $shell = Phake::mock('WyriHaximus\TwigView\Shell\CompileShell');
        Phake::when($shell)->plugin('bar:foo')->thenCallParent();

        $shell->plugin('bar:foo');
    }

    public function testFile()
    {
        $shell = Phake::mock('WyriHaximus\TwigView\Shell\CompileShell');
        Phake::when($shell)->file('foo:bar')->thenCallParent();

        $shell->file('foo:bar');

        Phake::verify($shell)->compileTemplate('foo:bar');
    }

    public function testGetOptionParser()
    {
        $this->assertInstanceOf('\Cake\Console\ConsoleOptionParser', (new CompileShell())->getOptionParser());
    }

    public function testCompileTemplate()
    {
        $twig = Phake::mock('Twig_Environment');

        $twigView = Phake::mock('WyriHaximus\TwigView\View\TwigView');
        Phake::when($twigView)->getTwig()->thenReturn($twig);

        $shell = new CompileShell();
        $shell->setTwigview($twigView);
    }
}
