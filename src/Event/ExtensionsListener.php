<?php declare(strict_types=1);
/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WyriHaximus\TwigView\Event;

use Aptoma\Twig\Extension\MarkdownEngineInterface;
use Aptoma\Twig\Extension\MarkdownExtension;
use Aptoma\Twig\TokenParser\MarkdownTokenParser;
// use Ajgl\Twig\Extension\BreakpointExtension; // FIXME Not ported to Twig 2.x yet
use Asm89\Twig\CacheExtension\CacheStrategy\LifetimeCacheStrategy;
use Asm89\Twig\CacheExtension\Extension as CacheExtension;
use Cake\Core\Configure;
use Cake\Event\EventListenerInterface;
// use Jasny\Twig\ArrayExtension; // FIXME Not ported to Twig 2.x yet
// use Jasny\Twig\DateExtension; // FIXME Not ported to Twig 2.x yet
// use Jasny\Twig\PcreExtension; // FIXME Not ported to Twig 2.x yet
// use Jasny\Twig\TextExtension; // FIXME Not ported to Twig 2.x yet
use WyriHaximus\TwigView\Lib\Cache;
use WyriHaximus\TwigView\Lib\Twig\Extension;

/**
 * Class ExtensionsListener.
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
            ConstructEvent::EVENT => 'construct',
        ];
    }

    /**
     * Event handler.
     *
     * @param ConstructEvent $event Event.
     *
     */
    public function construct(ConstructEvent $event)
    {
        // Twig core extensions
        $event->getTwig()->addExtension(new \Twig_Extension_StringLoader());
        $event->getTwig()->addExtension(new \Twig_Extension_Debug());

        // CakePHP bridging extensions
        $event->getTwig()->addExtension(new Extension\I18n());
        $event->getTwig()->addExtension(new Extension\Time());
        $event->getTwig()->addExtension(new Extension\Basic());
        $event->getTwig()->addExtension(new Extension\Number());
        $event->getTwig()->addExtension(new Extension\Utils());
        $event->getTwig()->addExtension(new Extension\Arrays());
        $event->getTwig()->addExtension(new Extension\Strings());
        $event->getTwig()->addExtension(new Extension\Inflector());

        // Markdown extension
        if (
            Configure::check('WyriHaximus.TwigView.markdown.engine') &&
            Configure::read('WyriHaximus.TwigView.markdown.engine') instanceof MarkdownEngineInterface
        ) {
            $engine = Configure::read('WyriHaximus.TwigView.markdown.engine');
            $event->getTwig()->addExtension(new MarkdownExtension($engine));
            $event->getTwig()->addTokenParser(new MarkdownTokenParser($engine));
        }

        // Third party cache extension
        $cacheProvider = new Cache();
        $cacheStrategy = new LifetimeCacheStrategy($cacheProvider);
        $cacheExtension = new CacheExtension($cacheStrategy);
        $event->getTwig()->addExtension($cacheExtension);

        // jasny/twig-extensions
        // $event->getTwig()->addExtension(new DateExtension()); // FIXME Not ported to Twig 2.x yet
        // $event->getTwig()->addExtension(new PcreExtension()); // FIXME Not ported to Twig 2.x yet
        // $event->getTwig()->addExtension(new TextExtension()); // FIXME Not ported to Twig 2.x yet
        // $event->getTwig()->addExtension(new ArrayExtension()); // FIXME Not ported to Twig 2.x yet

        // Breakpoint extension
        if (Configure::read('debug') === true) {
            // $event->getTwig()->addExtension(new BreakpointExtension()); // FIXME Not ported to Twig 2.x yet
        }
    }
}
