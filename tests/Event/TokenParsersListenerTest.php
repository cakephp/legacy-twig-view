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

use Cake\TestSuite\TestCase;
use Phake;
use WyriHaximus\TwigView\Event\TokenParsersListener;

/**
 * Class TokenParserListenerTest
 * @package WyriHaximus\CakePHP\Tests\TwigView\Event
 */
class TokenParsersListenerTest extends TestCase
{

	public function testImplementedEvents()
	{
		$eventsList = (new TokenParsersListener)->implementedEvents();
		$this->assertInternalType('array', $eventsList);
		$this->assertSame(1, count($eventsList));
	}

	public function testConstruct()
	{
		$twig = Phake::mock('\Twig_Environment');

		$twigView = Phake::mock('WyriHaximus\TwigView\View\TwigView');
		Phake::when($twigView)->getTwig()->thenReturn($twig);

		$event = Phake::mock('Cake\Event\Event');
		Phake::when($event)->subject()->thenReturn($twigView);

		(new TokenParsersListener())->construct($event);

		Phake::verify($twig, Phake::atLeast(1))->addTokenParser($this->isInstanceOf('\Twig_TokenParser_Include'));
	}

}