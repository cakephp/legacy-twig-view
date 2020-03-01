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

use Cake\Core\Configure;
use Cake\Event\EventListenerInterface;
use Cake\TwigView\Lib\Twig\Extension;
use Jasny\Twig\ArrayExtension;
use Jasny\Twig\DateExtension;
use Jasny\Twig\PcreExtension;
use Jasny\Twig\TextExtension;
use Twig\Extension\DebugExtension;
use Twig\Extension\StringLoaderExtension;
use Twig\Extra\Markdown\MarkdownExtension;
use Twig\Extra\Markdown\MarkdownInterface;
use Twig\Extra\Markdown\MarkdownRuntime;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

/**
 * Class ExtensionsListener.
 */
final class ExtensionsListener implements EventListenerInterface
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
        if ($event->getTwig()->hasExtension(StringLoaderExtension::class)) {
            return;
        }

        // Twig core extensions
        $event->getTwig()->addExtension(new StringLoaderExtension());
        $event->getTwig()->addExtension(new DebugExtension());

        // CakePHP bridging extensions
        $event->getTwig()->addExtension(new Extension\I18n());
        $event->getTwig()->addExtension(new Extension\Time());
        $event->getTwig()->addExtension(new Extension\Basic());
        $event->getTwig()->addExtension(new Extension\Number());
        $event->getTwig()->addExtension(new Extension\Utils());
        $event->getTwig()->addExtension(new Extension\Arrays());
        $event->getTwig()->addExtension(new Extension\Strings());
        $event->getTwig()->addExtension(new Extension\Inflector());

        if (
            !Configure::check('TwigView.flags.potentialDangerous') ||
            (
                Configure::check('TwigView.flags.potentialDangerous') &&
                Configure::read('TwigView.flags.potentialDangerous') === true
            )
        ) {
            $event->getTwig()->addExtension(new Extension\PotentialDangerous());
        }

        // Markdown extension
        if (
            Configure::check('TwigView.markdown.engine') &&
            Configure::read('TwigView.markdown.engine') instanceof MarkdownInterface
        ) {
            $engine = Configure::read('TwigView.markdown.engine');
            $event->getTwig()->addExtension(new MarkdownExtension());

            $event->getTwig()->addRuntimeLoader(new class ($engine) implements RuntimeLoaderInterface {
                /**
                 * @var \Twig\Extra\Markdown\MarkdownInterface
                 */
                private $engine;

                /**
                 * @param \Twig\Extra\Markdown\MarkdownInterface $engine MarkdownInterface instance
                 */
                public function __construct(MarkdownInterface $engine)
                {
                    $this->engine = $engine;
                }

                /**
                 * @param string $class FQCN
                 * @return object|null
                 */
                public function load($class)
                {
                    if ($class === MarkdownRuntime::class) {
                        return new MarkdownRuntime($this->engine);
                    }

                    return null;
                }
            });
        }

        // jasny/twig-extensions
        $event->getTwig()->addExtension(new DateExtension());
        $event->getTwig()->addExtension(new PcreExtension());
        $event->getTwig()->addExtension(new TextExtension());
        $event->getTwig()->addExtension(new ArrayExtension());
        // @codingStandardsIgnoreEnd
    }
}

// phpcs:disable
class_alias('Cake\TwigView\Event\ExtensionsListener', 'Wyrihaximus\TwigView\Event\ExtensionsListener');
// phpcs:enable
