<?php declare(strict_types=1);
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

class LoaderEvent extends Event
{
    const EVENT = 'TwigView.TwigView.loader';

    /**
     * @param  \Twig\Loader\LoaderInterface $loader
     * @return LoaderEvent
     */
    public static function create(\Twig\Loader\LoaderInterface $loader)
    {
        return new static(static::EVENT, $loader, [
            'loader' => $loader,
        ]);
    }

    /**
     * @return \Twig\Loader\LoaderInterface
     */
    public function getLoader()
    {
        return $this->subject();
    }

    /**
     * @return string|Twig\Loader\LoaderInterface
     */
    public function getResultLoader()
    {
        if ($this->result instanceof \Twig\Loader\LoaderInterface) {
            return $this->result;
        }

        if (is_array($this->result) && $this->result['loader'] instanceof \Twig\Loader\LoaderInterface) {
            return $this->result['loader'];
        }

        return $this->getLoader();
    }
}
