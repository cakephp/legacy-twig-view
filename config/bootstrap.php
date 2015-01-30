<?php

use Cake\Event\EventManager;
use WyriHaximus\TwigView\Event;

EventManager::instance()->attach(new Event\ExtensionsListener());
EventManager::instance()->attach(new Event\TokenParsersListener());

// Debug kit profiler
if (Configure::read('debug')) {
    EventManager::instance()->attach(new Event\ProfilerListener());
}
