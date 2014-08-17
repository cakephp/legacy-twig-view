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
