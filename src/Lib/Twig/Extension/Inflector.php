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
 * Class Inflector
 * @package WyriHaximus\CakePHP\TwigView\Lib\Twig\Extension
 */
class Inflector extends \Twig_Extension {

    /**
     * @return array
     */
    public function getFilters() {
        return [
            'pluralize' => new \Twig_Filter_Function('Cake\Utility\Inflector::pluralize'),
            'singularize' => new \Twig_Filter_Function('Cake\Utility\Inflector::singularize'),
            'camelize' => new \Twig_Filter_Function('Cake\Utility\Inflector::camelize'),
            'underscore' => new \Twig_Filter_Function('Cake\Utility\Inflector::underscore'),
            'humanize' => new \Twig_Filter_Function('Cake\Utility\Inflector::humanize'),
            'tableize' => new \Twig_Filter_Function('Cake\Utility\Inflector::tableize'),
            'classify' => new \Twig_Filter_Function('Cake\Utility\Inflector::classify'),
            'variable' => new \Twig_Filter_Function('Cake\Utility\Inflector::variable'),
            'slug' => new \Twig_Filter_Function('Cake\Utility\Inflector::slug'),
        ];
    }

    /**
     * @return string
     */
    public function getName() {
        return 'inflector';
    }
}