<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\TwigView\Lib\Twig\Extension;

/**
 * Class Number
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
class Number extends \Twig_Extension {

/**
 * Get declared functions
 *
 * @return \Twig_SimpleFilter[]
 */
	public function getFilters() {
		return [
			new \Twig_SimpleFilter('toReadableSize', 'Cake\Utility\Number::toReadableSize'),
			new \Twig_SimpleFilter('fromReadableSize', 'Cake\Utility\Number::fromReadableSize'),
			new \Twig_SimpleFilter('toPercentage', 'Cake\Utility\Number::toPercentage'),
			new \Twig_SimpleFilter('format', 'Cake\Utility\Number::format'),
			new \Twig_SimpleFilter('formatDelta', 'Cake\Utility\Number::formatDelta'),
			new \Twig_SimpleFilter('currency', 'Cake\Utility\Number::currency'),
		];
	}

/**
 * Get declared functions
 *
 * @return \Twig_SimpleFunction[]
 */
	public function getFunctions() {
		return [
			new \Twig_SimpleFunction('defaultCurrency', 'Cake\Utility\Number::defaultCurrency'),
			new \Twig_SimpleFunction('number_formatter', 'Cake\Utility\Number::formatter'),
		];
	}

/**
 * get extension name
 *
 * @return string
 */
	public function getName() {
		return 'string';
	}
}
