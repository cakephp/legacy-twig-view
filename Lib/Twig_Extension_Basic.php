<?php
/**
 * CakePHP Basic functions
 *
 * Use: {{ user|debug }}
 * Use: {{ user|pr }}
 * Use: {{ 'FOO'|low }}
 * Use: {{ 'foo'|up }}
 * Use: {{ 'HTTP_HOST'|env }}
 *
 * @author Hiroshi Hoaki <rewish.org@gmail.com>
 * @package TwigView
 * @subpackage TwigView.Lib
 */
class Twig_Extension_Basic extends Twig_Extension {

/**
 * Returns a list of filters to add to the existing list.
 *
 * @return array An array of filters
 */
	public function getFilters() {
		return array(
			'debug' => new Twig_Filter_Function('debug'),
			'pr'    => new Twig_Filter_Function('pr'),
			'low'   => new Twig_Filter_Function('low'),
			'up'    => new Twig_Filter_Function('up'),
			'env'   => new Twig_Filter_Function('env'),
		);
	}

/**
* Returns the name of the extension.
*
* @return string The extension name
*/
	public function getName() {
		return 'basic';
	}
}
