<?php

class Cake_String_Filters
{
/**
 * substr wrapper
 * @param $str
 * @return string
 */
    public static function substr($haystack, $a = null, $b = null) {
        return substr($haystack, $a, $b);
    }
}

class Twig_Extension_String extends Twig_Extension {

/**
 * Returns a list of filters to add to the existing list.
 *
 * @return array An array of filters
 */
	public function getFilters() {
		return array(
			'substr' => new Twig_Filter_Function('Cake_String_Filters::substr'),
		);
	}

/**
 * Returns the name of the extension.
 *
 * @return string The extension name
 */
	public function getName() {
		return 'string';
	}
}