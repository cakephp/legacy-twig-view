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
 * Class String
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
class String extends \Twig_Extension
{

    /**
     * Get declared filters
     *
     * @return \Twig_SimpleFilter[]
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('substr', 'substr'),
            new \Twig_SimpleFilter('tokenize', 'Cake\Utility\String::tokenize'),
            new \Twig_SimpleFilter('insert', 'Cake\Utility\String::insert'),
            new \Twig_SimpleFilter('cleanInsert', 'Cake\Utility\String::cleanInsert'),
            new \Twig_SimpleFilter('wrap', 'Cake\Utility\String::wrap'),
            new \Twig_SimpleFilter('wordWrap', 'Cake\Utility\String::wordWrap'),
            new \Twig_SimpleFilter('highlight', 'Cake\Utility\String::highlight'),
            new \Twig_SimpleFilter('tail', 'Cake\Utility\String::tail'),
            new \Twig_SimpleFilter('truncate', 'Cake\Utility\String::truncate'),
            new \Twig_SimpleFilter('excerpt', 'Cake\Utility\String::excerpt'),
            new \Twig_SimpleFilter('toList', 'Cake\Utility\String::toList'),
            new \Twig_SimpleFilter('stripLinks', 'Cake\Utility\String::stripLinks'),
            new \Twig_SimpleFilter('isMultibyte', 'Cake\Utility\String::isMultibyte'),
            new \Twig_SimpleFilter('utf8', 'Cake\Utility\String::utf8'),
            new \Twig_SimpleFilter('ascii', 'Cake\Utility\String::ascii'),
        ];
    }

    /**
     * Get declared functions
     *
     * @return \Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('uuid', 'Cake\Utility\String::uuid'),
        ];
    }

    /**
     * Get extension name
     *
     * @return string
     */
    public function getName()
    {
        return 'string';
    }
}
