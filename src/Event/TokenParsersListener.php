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
use Cake\TwigView\Lib\Twig\TokenParser;
use LogicException;

/**
 * Class TokenParsersListener.
 */
final class TokenParsersListener implements EventListenerInterface
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
        // CakePHP specific tags
        try {
            $event->getTwig()->addTokenParser(new TokenParser\Cell());
            $event->getTwig()->addTokenParser(new TokenParser\Element());
        } catch (LogicException $d) {
            // Nothing to do as token parser already added.
        }
    }
}

// phpcs:disable
class_alias('Cake\TwigView\Event\TokenParsersListener', 'Wyrihaximus\TwigView\Event\TokenParsersListener');
// phpcs:enable
