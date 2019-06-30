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
use Twig\Loader\LoaderInterface;

final class LoaderEvent extends Event
{
    public const EVENT = 'TwigView.TwigView.loader';

    /**
     * @param  \Twig\Loader\LoaderInterface $loader
     * @return static
     */
    public static function create(LoaderInterface $loader): LoaderEvent
    {
        return new static(static::EVENT, $loader, [
            'loader' => $loader,
        ]);
    }

    /**
     * @return \Twig\Loader\LoaderInterface
     */
    public function getLoader(): LoaderInterface
    {
        return $this->getSubject();
    }

    /**
     * @return string|\WyriHaximus\TwigView\Event\Twig\Loader\LoaderInterface
     */
    public function getResultLoader(): LoaderInterface
    {
        if ($this->result instanceof LoaderInterface) {
            return $this->result;
        }

        if (is_array($this->result) && $this->result['loader'] instanceof LoaderInterface) {
            return $this->result['loader'];
        }

        return $this->getLoader();
    }
}
