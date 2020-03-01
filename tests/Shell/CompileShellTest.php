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

namespace Cake\TwigView\Test\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\TwigView\Lib\Scanner;
use Cake\TwigView\Shell\CompileShell;
use Cake\TwigView\Test\TestCase;
use Cake\TwigView\View\TwigView;
use Twig\Environment;
use Twig\Template;
use Twig\TemplateWrapper;

/**
 * Class CompileShell.
 * @package Cake\TwigView\Shell
 */
class CompileShellTest extends TestCase
{
    public function testAll()
    {
        $twig = $this->prophesize(Environment::class);
        $twig->getExtensions()->shouldBeCalled()->willReturn([]);
        foreach (Scanner::all() as $section => $templates) {
            foreach ($templates as $template) {
                $twig->load($template)->shouldBeCalled()->willReturn(new TemplateWrapper($twig->reveal(), new class ($twig->reveal()) extends Template {
                    public function getTemplateName()
                    {
                    }

                    public function getDebugInfo()
                    {
                    }

                    public function getSourceContext()
                    {
                    }

                    protected function doDisplay(array $context, array $blocks = [])
                    {
                    }
                }));
            }
        }

        $twigView = new TwigView();
        $twigView->setTwig($twig->reveal());

        $shell = new CompileShell();
        $shell->setTwigview($twigView);
        $shell->all();
    }

    public function testPlugin()
    {
        $this->expectException(\Exception::class);

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
        $twig->getExtensions()->shouldBeCalled()->willReturn([]);
        $twig->load('foo:bar')->shouldBeCalled()->willReturn(new TemplateWrapper($twig->reveal(), new class ($twig->reveal()) extends Template {
            public function getTemplateName()
            {
            }

            public function getDebugInfo()
            {
            }

            public function getSourceContext()
            {
            }

            protected function doDisplay(array $context, array $blocks = [])
            {
            }
        }));

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
