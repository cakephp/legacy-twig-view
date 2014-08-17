<?php

use Cake\Event\EventManager;
use WyriHaximus\CakePHP\TwigView\Event\ExtensionsListener;

EventManager::instance()->attach(new ExtensionsListener());
