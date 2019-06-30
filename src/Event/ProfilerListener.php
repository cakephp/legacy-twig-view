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

namespace WyriHaximus\TwigView\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Twig\Profiler\Profile;
use WyriHaximus\TwigView\Lib\Twig\Extension;

/**
 * Class ExtensionsListener.
 * @package WyriHaximus\TwigView\Event
 */
final class ProfilerListener implements EventListenerInterface
{
    /**
     * Return implemented events.
     *
     * @return array
     */
    public function implementedEvents(): array
    {
        return [
            ConstructEvent::EVENT => 'construct',
        ];
    }

    /**
     * Event handler.
     *
     * @param \WyriHaximus\TwigView\Event\ConstructEvent $event Event.
     *
     */
    public function construct(ConstructEvent $event)
    {
        if ($event->getTwig()->hasExtension(Extension\Profiler::class)) {
            return;
        }

        $profile = new Profile();
        $event->getTwig()->addExtension(new Extension\Profiler($profile));

        EventManager::instance()->dispatch(ProfileEvent::create($profile));
    }
}
