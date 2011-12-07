<?php

App::import('Lib', 'TwigView.ElementToken');

/**
 * Core Extension
 *
 * @package TwigView
 * @subpackage TwigView.Lib
 */
class CoreExtension extends Twig_Extension_Core {
	public function getTokenParsers() {
		return array_merge(
			parent::getTokenParsers(),
			array(
				new Twig_TokenParser_Element()
			)
		);
	}
}
