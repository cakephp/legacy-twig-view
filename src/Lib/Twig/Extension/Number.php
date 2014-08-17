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
 * Class Number
 * @package WyriHaximus\CakePHP\TwigView\Lib\Twig\Extension
 */
class Number extends \Twig_Extension {

    /**
     * @return array
     */
    public function getFilters() {
        return [
            'toReadableSize' => new \Twig_Filter_Function('Cake\Utility\Number::toReadableSize'),
            'fromReadableSize' => new \Twig_Filter_Function('Cake\Utility\Number::fromReadableSize'),
            'toPercentage' => new \Twig_Filter_Function('Cake\Utility\Number::toPercentage'),
            'format' => new \Twig_Filter_Function('Cake\Utility\Number::format'),
            'formatDelta' => new \Twig_Filter_Function('Cake\Utility\Number::formatDelta'),
            'currency' => new \Twig_Filter_Function('Cake\Utility\Number::currency'),
        ];
    }

    /**
     * @return array
     */
    public function getFunctions() {
        return [
            'defaultCurrency' => new \Twig_Filter_Function('Cake\Utility\Number::defaultCurrency'),
            'number_formatter' => new \Twig_Filter_Function('Cake\Utility\Number::formatter'),
        ];
    }

    /**
     * @return string
     */
    public function getName() {
        return 'string';
    }
}
