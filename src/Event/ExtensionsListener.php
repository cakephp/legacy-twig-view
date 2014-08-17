<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\CakePHP\TwigView\Event;

use Cake\Event\Event;
use Cake\Event\EventListener;
use WyriHaximus\CakePHP\TwigView\Lib\Twig\Extension;

/**
 * Class ExtensionsListener
 * @package WyriHaximus\CakePHP\TwigView\Event
 */
class ExtensionsListener implements EventListener {

    /**
     * @return array
     */
    public function implementedEvents() {
        return [
            'TwigView.TwigView.construct' => 'construct',
        ];
    }

    /**
     * @param Event $event
     */
    public function construct(Event $event) {
        $event->subject()->getTwig()->addExtension(new \Twig_Extension_StringLoader);
        $event->subject()->getTwig()->addExtension(new Extension\I18n);
        $event->subject()->getTwig()->addExtension(new Extension\Time);
        $event->subject()->getTwig()->addExtension(new Extension\Basic);
        $event->subject()->getTwig()->addExtension(new Extension\Number);
        $event->subject()->getTwig()->addExtension(new Extension\Utils);
        $event->subject()->getTwig()->addExtension(new Extension\Arrays);
        $event->subject()->getTwig()->addExtension(new Extension\String);
        $event->subject()->getTwig()->addExtension(new Extension\Inflector);
    }
}
