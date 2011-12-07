<?php

App::import('Helper', 'Number');

/**
 * Number Helper Filters
 * 
 * Use: {{ '3535839525'|size }} //=> 3.29 GB
 * Use: {{ '0.555'|p(2) }} //=> 0.56
 * Use: {{ '5999'|curr }} //=> $5,999.00
 * Use: {{ '2.3'|pct }} //=> 2.30%
 * 
 *
 * @author Kjell Bublitz <m3nt0r.de@gmail.com>
 * @package TwigView
 * @subpackage TwigView.Lib
 */
class Cake_Number_Filters {

/**
 * Wrapper to Number->toReadableSize()
 * 
 * @param integer $length Size in bytes
 */
	static function size($var) {
		$number = new NumberHelper();
		return $number->toReadableSize($var);
	}

/**
 * Wrapper to Number->toPercentage()
 * 
 * @param float $number A floating point number
 * @param integer $precision The precision of the returned number
 */
	static function percentage($var, $p = 2) {
		$number = new NumberHelper();
		return $number->toPercentage($var, $p);
	}

/**
 * Wrapper to Number->currency()
 * 
 * @param float $number
 * @param string $currency Valid values are 'USD', 'EUR', 'GBP'
 * @param array $options f.e. 'before' and 'after' options.
 */
	static function currency($var, $curr='USD', $opts=array()) {
		$number = new NumberHelper();
		return $number->currency($var, $curr, $opts);
	}

/**
 * Wrapper to Number->precision()
 * 
 * @param float $number A floating point number
 * @param integer $precision The precision of the returned number
 */
	static function precision($var, $p=2) {
		$number = new NumberHelper();
		return $number->precision($var, $p);
	}
}

/**
 * Twig_Extension_Number
 * 
 * Use: {{ '3535839525'|size }} //=> 3.29 GB
 * Use: {{ '0.555'|p(2) }} //=> 0.56
 * Use: {{ '5999'|curr }} //=> $5,999.00
 * Use: {{ '2.3'|pct }} //=> 2.30%
 * 
 * @author Kjell Bublitz <m3nt0r.de@gmail.com>
 * @package TwigView
 * @subpackage TwigView.Lib
 */
class Twig_Extension_Number extends Twig_Extension {

/**
 * Returns a list of filters to add to the existing list.
 *
 * @return array An array of filters
 */
	public function getFilters() {
		return array(
			'size' => new Twig_Filter_Function('Cake_Number_Filters::size'),
			'pct'  => new Twig_Filter_Function('Cake_Number_Filters::percentage'),
			'curr' => new Twig_Filter_Function('Cake_Number_Filters::currency'),
			'p'    => new Twig_Filter_Function('Cake_Number_Filters::precision'),
		);
	}

/**
 * Returns the name of the extension.
 *
 * @return string The extension name
 */
	public function getName() {
		return 'number';
	}
}
