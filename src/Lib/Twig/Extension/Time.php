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
 * Class Time
 * @package WyriHaximus\CakePHP\TwigView\Lib\Twig\Extension
 */
class Time extends \Twig_Extension {

    /**
     * @return array
     */
    public function getFunctions() {
		return [
            'time' => new \Twig_Filter_Function(function($time = null, $tz = null) {
                return new \Cake\Utility\Time($time, $tz);
            }),
            'timezones' => new \Twig_Filter_Function('Cake\Utility\Time::listTimezones'),
        ];
	}

    /**
     * @return string
     */
    public function getName() {
		return 'time';
	}
}
