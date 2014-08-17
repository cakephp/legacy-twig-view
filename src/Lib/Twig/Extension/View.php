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
 * Class View
 * @package WyriHaximus\CakePHP\TwigView\Lib\Twig\Extension
 */
class View extends \Twig_Extension {

    /**
     * @var View
     */
    protected $view;

    /**
     * @param View $view
     */
    public function __construct(View $view) {
        $this->view = $view;
    }

    /**
     * @return array
     */
    public function getFunctions() {
		return [
			new \Twig_SimpleFunction('elementExists', function($name) {
                return $this->view->elementExists($name);
            }),
			new \Twig_SimpleFunction('getVars', function() {
                return $this->view->getVars();
            }),
            new \Twig_SimpleFunction('get', function($var, $default = null) {
                return $this->view->get($var, $default);
            }),
		];
	}

    /**
     * @return string
     */
    public function getName() {
		return 'view';
	}
}
