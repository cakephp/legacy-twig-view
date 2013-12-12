<?php
class Cake_Inflector_Filters
{

/**
 * Inflector::camelize wrapper
 * @param $str
 * @return string
 */
    public static function camelize($str) {
        return Inflector::camelize($str);
    }

/**
 * Inflector::classify wrapper
 * @param $str
 * @return string
 */
    public static function classify($str) {
        return Inflector::classify($str);
    }

/**
 * Inflector::humanize wrapper
 * @param $str
 * @return string
 */
    public static function humanize($str) {
        return Inflector::humanize($str);
    }

/**
 * Inflector::pluralize wrapper
 * @param $str
 * @return string
 */
    public static function pluralize($str) {
        return Inflector::pluralize($str);
    }

/**
 * Inflector::singularize wrapper
 * @param $str
 * @return string
 */
    public static function singularize($str) {
        return Inflector::singularize($str);
    }

/**
 * Inflector::slug wrapper
 * @param $str
 * @return string
 */
    public static function slug($str) {
        return Inflector::slug($str);
    }

/**
 * Inflector::tableize wrapper
 * @param $str
 * @return string
 */
    public static function tableize($str) {
        return Inflector::tableize($str);
    }

/**
 * Inflector::underscore wrapper
 * @param $str
 * @return string
 */
    public static function underscore($str) {
        return Inflector::underscore($str);
    }

/**
 * Inflector::variable wrapper
 * @param $str
 * @return string
 */
    public static function variable($str) {
        return Inflector::variable($str);
    }
}

class Twig_Extension_Inflector extends Twig_Extension {

/**
 * Returns a list of filters to add to the existing list.
 *
 * @return array An array of filters
 */
	public function getFilters() {
		return array(
			'camelize' => new Twig_Filter_Function('Cake_Inflector_Filters::camelize'),
			'classify' => new Twig_Filter_Function('Cake_Inflector_Filters::classify'),
			'humanize' => new Twig_Filter_Function('Cake_Inflector_Filters::humanize'),
			'pluralize' => new Twig_Filter_Function('Cake_Inflector_Filters::pluralize'),
			'singularize' => new Twig_Filter_Function('Cake_Inflector_Filters::singularize'),
			'slug' => new Twig_Filter_Function('Cake_Inflector_Filters::slug'),
			'tableize' => new Twig_Filter_Function('Cake_Inflector_Filters::tableize'),
			'underscore' => new Twig_Filter_Function('Cake_Inflector_Filters::underscore'),
			'variable' => new Twig_Filter_Function('Cake_Inflector_Filters::variable'),
		);
	}

/**
 * Returns the name of the extension.
 *
 * @return string The extension name
 */
	public function getName() {
		return 'inflector';
	}
}