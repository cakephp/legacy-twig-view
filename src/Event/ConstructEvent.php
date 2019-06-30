<?php
declare(strict_types=1);

/**
 * This file is part of TwigView.
 *
 ** (c) 2015 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WyriHaximus\TwigView\Event;

use Cake\Event\Event;
use Twig\Environment;
use WyriHaximus\TwigView\View\TwigView;

final class ConstructEvent extends Event
{
    public const EVENT = 'TwigView.TwigView.construct';

    /**
     * @param  \WyriHaximus\TwigView\View\TwigView          $twigView
     * @param  \Twig\Environment $twig
     * @return static
     */
    public static function create(TwigView $twigView, Environment $twig): ConstructEvent
    {
        return new static(static::EVENT, $twigView, [
            'twigView' => $twigView,
            'twig' => $twig,
        ]);
    }

    /**
     * @return \WyriHaximus\TwigView\View\TwigView
     */
    public function getTwigView(): TwigView
    {
        return $this->getData()['twigView'];
    }

    /**
     * @return \Twig\Environment
     */
    public function getTwig(): Environment
    {
        return $this->getData()['twig'];
    }
}
