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

namespace WyriHaximus\CakePHP\Tests\TwigView\Shell;

use Cake\Console\ConsoleOptionParser;
use Twig\Environment;
use WyriHaximus\CakePHP\Tests\TwigView\TestCase;
use WyriHaximus\PHPUnit\Helpers\ReflectionTrait;
use WyriHaximus\TwigView\Lib\Scanner;
use WyriHaximus\TwigView\Shell\CompileShell;
use WyriHaximus\TwigView\View\TwigView;

/**
 * Class CompileShell.
 * @package WyriHaximus\TwigView\Shell
 */
class CompileShellTest extends TestCase
{
    use ReflectionTrait;

    public function testAll()
    {
        $twig = $this->prophesize(Environment::class);
        foreach (Scanner::all() as $section => $templates) {
            foreach ($templates as $template) {
                $twig->loadTemplate($template)->shouldBeCalled()->willReturn('');
            }
        }

        $twigView = new TwigView();
        $twigView->setTwig($twig->reveal());

        $shell = new CompileShell();
        $shell->setTwigview($twigView);
        $shell->all();
    }

    /**
     * @expectedException Exception
     */
    public function testPlugin()
    {
        $twig = $this->prophesize(Environment::class);

        $twigView = new TwigView();
        $twigView->setTwig($twig->reveal());

        $shell = new CompileShell();
        $shell->setTwigview($twigView);

        $shell->plugin('bar:foo');
    }

    public function testFile()
    {
        $twig = $this->prophesize(Environment::class);
        $twig->loadTemplate('foo:bar')->shouldBeCalled()->willReturn('');

        $twigView = new TwigView();
        $twigView->setTwig($twig->reveal());

        $shell = new CompileShell();
        $shell->setTwigview($twigView);

        $shell->file('foo:bar');
    }

    public function testGetOptionParser()
    {
        $this->assertInstanceOf(ConsoleOptionParser::class, (new CompileShell())->getOptionParser());
    }
}
