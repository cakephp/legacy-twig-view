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
 * Class Utils
 * @package WyriHaximus\CakePHP\TwigView\Lib\Twig\Extension
 */
class Utils extends \Twig_Extension {

    /**
     * @return array
     */
    public function getFilters() {
		return [
			'serialize' => new \Twig_Filter_Function('serialize'),
			'unserialize' => new \Twig_Filter_Function('unserialize'),
			'md5' => new \Twig_Filter_Function('md5'),
			'base64_encode' => new \Twig_Filter_Function('base64_encode'),
			'base64_decode' => new \Twig_Filter_Function('base64_decode'),
			'nl2br' => new \Twig_Filter_Function('nl2br'),
			'string' => new \Twig_Filter_Function(function($str) {
                return (string) $str;
            }),
		];
	}

    /**
     * @return string
     */
    public function getName() {
		return 'utils';
	}
}
