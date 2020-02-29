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

namespace Cake\TwigView\Event;

use Cake\Event\Event;
use Cake\TwigView\View\TwigView;
use Twig\Environment;

final class ConstructEvent extends Event
{
    public const EVENT = 'TwigView.TwigView.construct';

    /**
     * @param \Cake\TwigView\View\TwigView $twigView TwigView instance.
     * @param \Twig\Environment $twig Twig environment instance.
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
     * @return \Cake\TwigView\View\TwigView
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

// phpcs:disable
class_alias('Cake\TwigView\Event\ConstructEvent', 'Wyrihaximus\TwigView\Event\ConstructEvent');
// phpcs:enable
