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

namespace Cake\TwigView\Test\Event;

use Cake\Core\Configure;
use Cake\TwigView\Event\ConstructEvent;
use Cake\TwigView\Event\ExtensionsListener;
use Cake\TwigView\Test\TestCase;
use Cake\TwigView\View\TwigView;
use Prophecy\Argument;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\StringLoaderExtension;
use Twig\Extra\Markdown\MarkdownExtension;
use Twig\Extra\Markdown\MarkdownInterface;

/**
 * Class ExtensionsListenerTest.
 * @package Cake\TwigView\Test\Event
 */
class ExtensionsListenerTest extends TestCase
{
    public function testImplementedEvents()
    {
        $eventsList = (new ExtensionsListener())->implementedEvents();
        $this->assertIsArray($eventsList);
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
            'Cake.TwigView.markdown.engine',
            $this->prophesize(MarkdownInterface::class)->reveal()
        );

        $twig = $this->prophesize(Environment::class);
        $twig->hasExtension(StringLoaderExtension::class)->shouldBeCalled();
        $twig->addExtension(Argument::type(AbstractExtension::class))->shouldBeCalled();
        $twig->addExtension(Argument::type(MarkdownExtension::class))->shouldBeCalled();
        $twig->addRuntimeLoader(Argument::type('object'))->shouldBeCalled();

        $twigView = new TwigView();
        (new ExtensionsListener())->construct(ConstructEvent::create($twigView, $twig->reveal()));
    }

    public function testConstructNoMarkdownEngine()
    {
        $twig = $this->prophesize(Environment::class);
        $twig->hasExtension(StringLoaderExtension::class)->shouldBeCalled();
        $twig->addExtension(Argument::type(AbstractExtension::class))->shouldBeCalled();
        $twig->addExtension(Argument::type(MarkdownExtension::class))->shouldNotBeCalled();

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
