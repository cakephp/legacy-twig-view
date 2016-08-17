<?php
/**
 * This file is part of TwigView.
 *
 ** (c) 2015 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace App\View;

class AppView extends \WyriHaximus\TwigView\View\TwigView
{

    /**
     * Initialization hook method.
     *
     * Loads the necessary helper and properly configures them.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadHelper('TestSecond');
    }
}