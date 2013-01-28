<?php
class Cake_Array_Filters
{
    public static function in_array($needle, $haystack, $strict = FALSE) {
        return in_array($needle, $haystack ,$strict);
    }
    
    public static function explode($haystack, $needle) {
        return explode($needle, $haystack);
    }
    
    public static function cast_array($var) {
        return (array) $var;
    }
    
    public static function array_push($stack, $item) {
        $stack[] = $item;
        return $stack;
    }
    
    public static function array_add($stack, $key, $value) {
        $stack[$key] = $value;
        return $stack;
    }
    
    public static function array_prev($stack) {
        return prev($stack);
    }
    
    public static function array_next($stack) {
        return next($stack);
    }
    
    public static function array_current($stack) {
        return current($stack);
    }
    
    public static function array_each($stack) {
        return each($stack);
    }
}

class Twig_Extension_Array extends Twig_Extension {

/**
 * Returns a list of filters to add to the existing list.
 *
 * @return array An array of filters
 */
	public function getFilters() {
		return array(
			'in_array' => new Twig_Filter_Function('Cake_Array_Filters::in_array'),
			'explode' => new Twig_Filter_Function('Cake_Array_Filters::explode'),
			'array' => new Twig_Filter_Function('Cake_Array_Filters::cast_array'),
			'array_push' => new Twig_Filter_Function('Cake_Array_Filters::array_push'),
			'array_add' => new Twig_Filter_Function('Cake_Array_Filters::array_add'),
			'array_prev' => new Twig_Filter_Function('Cake_Array_Filters::array_prev'),
			'array_next' => new Twig_Filter_Function('Cake_Array_Filters::array_next'),
			'array_current' => new Twig_Filter_Function('Cake_Array_Filters::array_current'),
			'array_each' => new Twig_Filter_Function('Cake_Array_Filters::array_each'),
		);
	}

/**
 * Returns the name of the extension.
 *
 * @return string The extension name
 */
	public function getName() {
		return 'array';
	}
}