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
 * Class Inflector
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
class Inflector extends \Twig_Extension {

/**
 * Get filters for this extension
 *
 * @return \Twig_SimpleFunction[]
 */
	public function getFilters() {
		return [
			new \Twig_SimpleFunction('pluralize', 'Cake\Utility\Inflector::pluralize'),
			new \Twig_SimpleFunction('singularize', 'Cake\Utility\Inflector::singularize'),
			new \Twig_SimpleFunction('camelize', 'Cake\Utility\Inflector::camelize'),
			new \Twig_SimpleFunction('underscore', 'Cake\Utility\Inflector::underscore'),
			new \Twig_SimpleFunction('humanize', 'Cake\Utility\Inflector::humanize'),
			new \Twig_SimpleFunction('tableize', 'Cake\Utility\Inflector::tableize'),
			new \Twig_SimpleFunction('classify', 'Cake\Utility\Inflector::classify'),
			new \Twig_SimpleFunction('variable', 'Cake\Utility\Inflector::variable'),
			new \Twig_SimpleFunction('slug', 'Cake\Utility\Inflector::slug'),
		];
	}

/**
 * get extension name
 *
 * @return string
 */
	public function getName() {
		return 'inflector';
	}
}