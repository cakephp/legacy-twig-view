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
 * Class Basic
 * @package WyriHaximus\CakePHP\TwigView\Lib\Twig\Extension
 */
class Basic extends \Twig_Extension {

    /**
     * @return array
     */
    public function getFilters() {
		return [
			'debug' => new \Twig_Filter_Function('debug'),
			'pr'    => new \Twig_Filter_Function('pr'),
			'low'   => new \Twig_Filter_Function('low'),
			'up'    => new \Twig_Filter_Function('up'),
			'env'   => new \Twig_Filter_Function('env'),
			'count'   => new \Twig_Filter_Function('count'),
		];
	}

    /**
     * @return string
     */
    public function getName() {
		return 'basic';
	}
}
