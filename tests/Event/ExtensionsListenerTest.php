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

namespace WyriHaximus\CakePHP\Tests\TwigView\Event;

use Aptoma\Twig\Extension\MarkdownEngineInterface;
use Aptoma\Twig\Extension\MarkdownExtension;
use Aptoma\Twig\TokenParser\MarkdownTokenParser;
use Cake\Core\Configure;
use Prophecy\Argument;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\StringLoaderExtension;
use WyriHaximus\CakePHP\Tests\TwigView\TestCase;
use WyriHaximus\TwigView\Event\ConstructEvent;
use WyriHaximus\TwigView\Event\ExtensionsListener;
use WyriHaximus\TwigView\View\TwigView;

/**
 * Class ExtensionsListenerTest.
 * @package WyriHaximus\CakePHP\Tests\TwigView\Event
 */
class ExtensionsListenerTest extends TestCase
{
    public function testImplementedEvents()
    {
        $eventsList = (new ExtensionsListener())->implementedEvents();
        $this->assertInternalType('array', $eventsList);
        $this->assertSame(1, count($eventsList));
    }

    public function testConstruct()
    {
        $twig = $this->prophesize(Environment::class);
        $twig->hasExtension(StringLoaderExtension::class)->shouldBeCalled();
        $twig->addExtension(Argument::type(AbstractExtension::class))->shouldBeCalled();

        $twigView = new TwigView();
        (new ExtensionsListener())->construct(ConstructEvent::create($twigView, $twig->reveal()));
    }

    public function testConstructMarkdownEngine()
    {
        Configure::write(
            'WyriHaximus.TwigView.markdown.engine',
            $this->prophesize(MarkdownEngineInterface::class)->reveal()
        );

        $twig = $this->prophesize(Environment::class);
        $twig->hasExtension(StringLoaderExtension::class)->shouldBeCalled();
        $twig->addExtension(Argument::type(AbstractExtension::class))->shouldBeCalled();
        $twig->addExtension(Argument::type(MarkdownExtension::class))->shouldBeCalled();
        $twig->addTokenParser(Argument::type(MarkdownTokenParser::class))->shouldBeCalled();

        $twigView = new TwigView();
        (new ExtensionsListener())->construct(ConstructEvent::create($twigView, $twig->reveal()));
    }

    public function testConstructNoMarkdownEngine()
    {
        $twig = $this->prophesize(Environment::class);
        $twig->hasExtension(StringLoaderExtension::class)->shouldBeCalled();
        $twig->addExtension(Argument::type(AbstractExtension::class))->shouldBeCalled();
        $twig->addExtension(Argument::type(MarkdownExtension::class))->shouldNotBeCalled();
        $twig->addTokenParser(Argument::type(MarkdownTokenParser::class))->shouldNotBeCalled();

        $twigView = new TwigView();
        (new ExtensionsListener())->construct(ConstructEvent::create($twigView, $twig->reveal()));
    }

    public function testConstructDebug()
    {
        Configure::write('debug', true);

        $twig = $this->prophesize(Environment::class);
        $twig->hasExtension(StringLoaderExtension::class)->shouldBeCalled();
        $twig->addExtension(Argument::type(AbstractExtension::class))->shouldBeCalled();

        $twigView = new TwigView();
        (new ExtensionsListener())->construct(ConstructEvent::create($twigView, $twig->reveal()));
    }

    public function testConstructDebugFalse()
    {
        Configure::write('debug', false);

        $twig = $this->prophesize(Environment::class);
        $twig->hasExtension(StringLoaderExtension::class)->shouldBeCalled();
        $twig->addExtension(Argument::type(AbstractExtension::class))->shouldBeCalled();

        $twigView = new TwigView();
        (new ExtensionsListener())->construct(ConstructEvent::create($twigView, $twig->reveal()));
    }
}
