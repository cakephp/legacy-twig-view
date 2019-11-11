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

namespace WyriHaximus\TwigView;

use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\Plugin as CorePlugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Event\EventManager;

/**
 * Plugin class for WyriHaximus\TwigView.
 */
class Plugin extends BasePlugin
{
    /**
     * Load all the plugin configuration and bootstrap logic.
     *
     * @param \Cake\Core\PluginApplicationInterface $app The host application
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        EventManager::instance()->on(new Event\ExtensionsListener());
        EventManager::instance()->on(new Event\TokenParsersListener());

        if (Configure::read('debug') && CorePlugin::isLoaded('DebugKit')) {
            Configure::write('DebugKit.panels', array_merge(
                (array)Configure::read('DebugKit.panels'),
                [
                    'WyriHaximus/TwigView.Twig',
                ]
            ));
            EventManager::instance()->on(new Event\ProfilerListener());
        }
    }
}
