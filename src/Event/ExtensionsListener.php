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
class ExtensionsListener implements EventListenerInterface
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
    // @codingStandardsIgnoreStart
    public function construct(Event $event)
    {
        // @codingStandardsIgnoreEnd
        // @codingStandardsIgnoreStart
        // Twig core extensions
        $event->subject()->getTwig()->addExtension(new \Twig_Extension_StringLoader);
        $event->subject()->getTwig()->addExtension(new \Twig_Extension_Debug);

        // CakePHP bridging extensions
        $event->subject()->getTwig()->addExtension(new Extension\I18n);
        $event->subject()->getTwig()->addExtension(new Extension\Time);
        $event->subject()->getTwig()->addExtension(new Extension\Basic);
        $event->subject()->getTwig()->addExtension(new Extension\Number);
        $event->subject()->getTwig()->addExtension(new Extension\Utils);
        $event->subject()->getTwig()->addExtension(new Extension\Arrays);
        $event->subject()->getTwig()->addExtension(new Extension\String);
        $event->subject()->getTwig()->addExtension(new Extension\Inflector);

        // CakePHP specific tags
        $event->subject()->getTwig()->addTokenParser(new TokenParser\Cell);
        $event->subject()->getTwig()->addTokenParser(new TokenParser\Element);

        // Third party cache extension
        $cacheProvider = new Cache();
        $cacheStrategy = new LifetimeCacheStrategy($cacheProvider);
        $cacheExtension = new CacheExtension($cacheStrategy);
        $event->subject()->getTwig()->addExtension($cacheExtension);
        // @codingStandardsIgnoreEnd
    }
}
