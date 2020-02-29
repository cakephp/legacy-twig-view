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

use Cake\TwigView\Event\ConstructEvent;
use Cake\TwigView\Event\TokenParsersListener;
use Cake\TwigView\Test\TestCase;
use Cake\TwigView\View\TwigView;
use Prophecy\Argument;
use Twig\Environment;
use Twig\TokenParser\IncludeTokenParser;

/**
 * Class TokenParserListenerTest.
 * @package Cake\TwigView\Test\Event
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
