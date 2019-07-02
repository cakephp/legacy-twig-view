<?php
declare(strict_types=1);

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
use Twig\TwigFunction;

/**
 * Class View.
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
final class View extends AbstractExtension
{
    /**
     * View to call methods upon.
     *
     * @var \Cake\View\View
     */
    protected $view;

    /**
     * Constructor.
     *
     * @param \Cake\View\View $view View instance.
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
    public function getFunctions(): array
    {
        return [
            new TwigFunction('elementExists', function ($name) {
                return $this->view->elementExists($name);
            }),
            new TwigFunction('getVars', function () {
                return $this->view->getVars();
            }),
            new TwigFunction('get', function ($var, $default = null) {
                return $this->view->get($var, $default);
            }),
        ];
    }

    /**
     * Get extension name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'view';
    }
}
