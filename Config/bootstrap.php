<?php

App::uses('CakeEventManager', 'Event');
App::uses('TwigRegisterTwigExtentionsListener', 'TwigView.Event');

CakeEventManager::instance()->attach(new TwigRegisterTwigExtentionsListener());