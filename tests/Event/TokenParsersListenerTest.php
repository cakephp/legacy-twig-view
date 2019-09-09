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

use Prophecy\Argument;
use Twig\Environment;
use Twig\TokenParser\IncludeTokenParser;
use WyriHaximus\CakePHP\Tests\TwigView\TestCase;
use WyriHaximus\TwigView\Event\ConstructEvent;
use WyriHaximus\TwigView\Event\TokenParsersListener;
use WyriHaximus\TwigView\View\TwigView;

/**
 * Class TokenParserListenerTest.
 * @package WyriHaximus\CakePHP\Tests\TwigView\Event
 */
class TokenParsersListenerTest extends TestCase
{
    public function testImplementedEvents()
    {
        $eventsList = (new TokenParsersListener())->implementedEvents();
        $this->assertIsArray($eventsList);
        $this->assertSame(1, count($eventsList));
    }

    public function testConstruct()
    {
        $twig = $this->prophesize(Environment::class);
        $twig->addTokenParser(Argument::type(IncludeTokenParser::class))->shouldBeCalled();

        $twigView = new TwigView();
        (new TokenParsersListener())->construct(ConstructEvent::create($twigView, $twig->reveal()));
    }
}
