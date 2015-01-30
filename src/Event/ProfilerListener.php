<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\TwigView\Event;

use Asm89\Twig\CacheExtension\CacheStrategy\LifetimeCacheStrategy;
use Asm89\Twig\CacheExtension\Extension as CacheExtension;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use WyriHaximus\TwigView\Lib\Cache;
use WyriHaximus\TwigView\Lib\Twig\Extension;
use WyriHaximus\TwigView\Lib\Twig\TokenParser;

/**
 * Class ExtensionsListener
 * @package WyriHaximus\TwigView\Event
 */
class ProfilerListener implements EventListenerInterface
{
    /**
     * Return implemented events.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'TwigView.TwigView.construct' => 'construct',
        ];
    }

    /**
     * Event handler.
     *
     * @param Event $event Event.
     *
     * @return void
     */
    public function construct(Event $event)
    {
        $profile = new \Twig_Profiler_Profile();
        $event->
            subject()->
            getTwig()->
            addExtension(new Extension\Profiler($profile));
    }
}
