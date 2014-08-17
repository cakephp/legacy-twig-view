<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\CakePHP\TwigView\Lib\Twig\Extension;

/**
 * Class Arrays
 * @package WyriHaximus\CakePHP\TwigView\Lib\Twig\Extension
 */
class Arrays extends \Twig_Extension {

    /**
     * @return array
     */
    public function getFunctions() {
		return [
			'in_array' => new \Twig_Filter_Function('in_array'),
			'explode' => new \Twig_Filter_Function('explode'),
			'array' => new \Twig_Filter_Function(function($array) {
                return (array)$array;
            }),
			'array_push' => new \Twig_Filter_Function('push'),
			'array_add' => new \Twig_Filter_Function('add'),
			'array_prev' => new \Twig_Filter_Function('prev'),
			'array_next' => new \Twig_Filter_Function('next'),
			'array_current' => new \Twig_Filter_Function('current'),
			'array_each' => new \Twig_Filter_Function('each'),
		];
	}

    /**
     * @return string
     */
    public function getName() {
		return 'array';
	}
}
