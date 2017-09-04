<?php declare(strict_types=1);
/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WyriHaximus\TwigView\Lib\Twig\Extension;

use Cake\View\View as CakeView;
use Twig\Extension\AbstractExtension;

/**
 * Class View.
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
class View extends AbstractExtension
{
    /**
     * View to call methods upon.
     *
     * @var CakeView
     */
    protected $view;

    /**
     * Constructor.
     *
     * @param CakeView $view View instance.
     */
    public function __construct(CakeView $view)
    {
        $this->view = $view;
    }

    /**
     * Get declared functions.
     *
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('elementExists', function ($name) {
                return $this->view->elementExists($name);
            }),
            new \Twig\TwigFunction('getVars', function () {
                return $this->view->getVars();
            }),
            new \Twig\TwigFunction('get', function ($var, $default = null) {
                return $this->view->get($var, $default);
            }),
        ];
    }

    /**
     * Get extension name.
     *
     * @return string
     */
    public function getName()
    {
        return 'view';
    }
}
