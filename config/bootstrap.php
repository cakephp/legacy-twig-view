<?php

use Cake\Event\EventManager;
use WyriHaximus\TwigView\Event\ExtensionsListener;
use WyriHaximus\TwigView\Event\TokenParsersListener;

EventManager::instance()->attach(new ExtensionsListener());
EventManager::instance()->attach(new TokenParsersListener());
