<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\CakePHP\Tests\TwigView\Event;

use Aptoma\Twig\Extension\MarkdownEngineInterface;
use Aptoma\Twig\Extension\MarkdownExtension;
use Aptoma\Twig\TokenParser\MarkdownTokenParser;
use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use Phake;
use WyriHaximus\TwigView\Event\ConstructEvent;
use WyriHaximus\TwigView\Event\ExtensionsListener;

/**
 * Class ExtensionsListenerTest
 * @package WyriHaximus\CakePHP\Tests\TwigView\Event
 */
class ExtensionsListenerTest extends TestCase
{

	public function testImplementedEvents()
	{
		$eventsList = (new ExtensionsListener)->implementedEvents();
		$this->assertInternalType('array', $eventsList);
		$this->assertSame(1, count($eventsList));
	}

	public function testConstruct()
	{
		$twig = Phake::mock('\Twig_Environment');

		$twigView = Phake::mock('WyriHaximus\TwigView\View\TwigView');
		(new ExtensionsListener)->construct(ConstructEvent::create($twigView, $twig));

		Phake::verify($twig, Phake::atLeast(1))->addExtension($this->isInstanceOf('\Twig_Extension'));
	}

    public function testConstructMarkdownEngine()
    {
        Configure::write(
            'WyriHaximus.TwigView.markdown.engine',
            $this->prophesize(MarkdownEngineInterface::class)->reveal()
        );

        $twig = Phake::mock('\Twig_Environment');

        $twigView = Phake::mock('WyriHaximus\TwigView\View\TwigView');
        (new ExtensionsListener)->construct(ConstructEvent::create($twigView, $twig));

        Phake::verify($twig, Phake::atLeast(1))->addExtension($this->isInstanceOf('\Twig_Extension'));
        Phake::verify($twig)->addExtension($this->isInstanceOf(MarkdownExtension::class));
        Phake::verify($twig)->addTokenParser($this->isInstanceOf(MarkdownTokenParser::class));
    }

    public function testConstructNoMarkdownEngine()
    {
        $twig = Phake::mock('\Twig_Environment');

        $twigView = Phake::mock('WyriHaximus\TwigView\View\TwigView');
        (new ExtensionsListener)->construct(ConstructEvent::create($twigView, $twig));

        Phake::verify($twig, Phake::atLeast(1))->addExtension($this->isInstanceOf('\Twig_Extension'));
        Phake::verify($twig, Phake::never())->addExtension($this->isInstanceOf(MarkdownExtension::class));
        Phake::verify($twig, Phake::never())->addTokenParser($this->isInstanceOf(MarkdownTokenParser::class));
    }
}