<?php

App::uses('TimeHelper', 'View/Helper');

/**
 * Wrapper to Time->timeAgoInWords()
 */
function cakeAgo($var) {
	$time = new TimeHelper();
	return $time->timeAgoInWords($var);
}

/**
 * Time Ago in Words
 * Use: {{ user.User.created|ago }} 
 *
 * @author Kjell Bublitz <m3nt0r.de@gmail.com>
 * @package TwigView
 * @subpackage TwigView.Lib
 */
class Twig_Extension_Ago extends Twig_Extension {

/**
 * Returns a list of filters to add to the existing list.
 *
 * @return array An array of filters
 */
	public function getFilters() {
		return array('ago' => new Twig_Filter_Function('cakeAgo'));
	}

/**
 * Returns the name of the extension.
 *
 * @return string The extension name
 */
	public function getName() {
		return 'ago';
	}
}
