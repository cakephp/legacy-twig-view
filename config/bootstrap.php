<?php

use Cake\Core\Configure;
use Cake\Event\EventManager;
use WyriHaximus\TwigView\Event;

EventManager::instance()->attach(new Event\ExtensionsListener());
EventManager::instance()->attach(new Event\TokenParsersListener());

// Debug kit profiler
if (Configure::read('debug')) {
    Configure::write('DebugKit.panels', array_merge(
        (array)Configure::read('DebugKit.panels'),
        [
            'WyriHaximus/TwigView.Twig',
        ]
    ));
    EventManager::instance()->attach(new Event\ProfilerListener());
}
