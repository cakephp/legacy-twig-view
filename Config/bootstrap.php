<?php

Configure::write('TwigView', array(
	'Cache' => CakePlugin::path('TwigView') . 'tmp' . DS . 'views',
));

App::uses('CakeEventManager', 'Event');
App::uses('TwigRegisterTwigExtentionsListener', 'TwigView.Event');

CakeEventManager::instance()->attach(new TwigRegisterTwigExtentionsListener());