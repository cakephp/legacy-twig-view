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

namespace Cake\TwigView\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Cake\TwigView\Lib\Twig\Extension;
use Twig\Profiler\Profile;

/**
 * Class ExtensionsListener.
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
     * @param \Cake\TwigView\Event\ConstructEvent $event Event.
     * @return void
     */
    public function construct(ConstructEvent $event): void
    {
        if ($event->getTwig()->hasExtension(Extension\Profiler::class)) {
            return;
        }

        $profile = new Profile();
        $event->getTwig()->addExtension(new Extension\Profiler($profile));

        EventManager::instance()->dispatch(ProfileEvent::create($profile));
    }
}

// phpcs:disable
class_alias('Cake\TwigView\Event\ProfilerListener', 'Wyrihaximus\TwigView\Event\ProfilerListener');
// phpcs:enable
