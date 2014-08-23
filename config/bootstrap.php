<?php

use Cake\Event\EventManager;
use WyriHaximus\TwigView\Event\ExtensionsListener;

EventManager::instance()->attach(new ExtensionsListener());
