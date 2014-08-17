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
 * Class String
 * @package WyriHaximus\CakePHP\TwigView\Lib\Twig\Extension
 */
class String extends \Twig_Extension {

    /**
     * @return array
     */
    public function getFilters() {
		return [
            'substr' => new \Twig_Filter_Function('substr'),
            'tokenize' => new \Twig_Filter_Function('Cake\Utility\String::tokenize'),
            'insert' => new \Twig_Filter_Function('Cake\Utility\String::insert'),
            'cleanInsert' => new \Twig_Filter_Function('Cake\Utility\String::cleanInsert'),
            'wrap' => new \Twig_Filter_Function('Cake\Utility\String::wrap'),
            'wordWrap' => new \Twig_Filter_Function('Cake\Utility\String::wordWrap'),
            'highlight' => new \Twig_Filter_Function('Cake\Utility\String::highlight'),
            'tail' => new \Twig_Filter_Function('Cake\Utility\String::tail'),
            'truncate' => new \Twig_Filter_Function('Cake\Utility\String::truncate'),
            'excerpt' => new \Twig_Filter_Function('Cake\Utility\String::excerpt'),
            'toList' => new \Twig_Filter_Function('Cake\Utility\String::toList'),
            'stripLinks' => new \Twig_Filter_Function('Cake\Utility\String::stripLinks'),
			'isMultibyte' => new \Twig_Filter_Function('Cake\Utility\String::isMultibyte'),
			'utf8' => new \Twig_Filter_Function('Cake\Utility\String::utf8'),
			'ascii' => new \Twig_Filter_Function('Cake\Utility\String::ascii'),
		];
	}

    /**
     * @return array
     */
    public function getFunctions() {
        return [
            'uuid' => new \Twig_Filter_Function('Cake\Utility\String::uuid'),
        ];
    }

    /**
     * @return string
     */
    public function getName() {
		return 'string';
	}
}