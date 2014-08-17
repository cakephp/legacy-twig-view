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
 * Class I18n
 * @package WyriHaximus\CakePHP\TwigView\Lib\Twig\Extension
 */
class I18n extends \Twig_Extension {

    /**
     * @return array
     */
    public function getFunctions() {
		return [
			'__' => new \Twig_Filter_Function('__'),
			'__d' => new \Twig_Filter_Function('__d'),
			'__n' => new \Twig_Filter_Function('__n'),
			'__dn' => new \Twig_Filter_Function('__dn'),
		];
	}

    /**
     * @return string
     */
    public function getName() {
		return 'i18n';
	}
}
