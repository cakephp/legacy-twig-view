<?php

require dirname(__DIR__) . '/vendor/cakephp/cakephp/src/basics.php';
require dirname(__DIR__) . '/vendor/autoload.php';

define('APP', sys_get_temp_dir());
define('TMP', sys_get_temp_dir() . '/TwigViewTmp/');
define('CACHE', sys_get_temp_dir() . '/TwigViewTmp/cache/');
define('DS', DIRECTORY_SEPARATOR);
define('PLUGIN_REPO_ROOT', dirname(__DIR__) . DS);

$TMP = new \Cake\Utility\Folder(TMP);
$TMP->create(TMP . 'cache/models', 0777);
$TMP->create(TMP . 'cache/persistent', 0777);
$TMP->create(TMP . 'cache/views', 0777);

Cake\Core\Plugin::load('TwigView', [
    'namespace' => 'WyriHaximus\\CakePHP\TwigView',
    'path' => PLUGIN_REPO_ROOT . 'src' . DS,
]);
Cake\Core\Configure::write('App', [
	'namespace' => 'App'
]);

$cache = [
    'default' => [
        'engine' => 'File'
    ],
    '_cake_core_' => [
        'className' => 'File',
        'prefix' => '_cake_core_',
        'path' => CACHE . 'persistent/',
        'serialize' => true,
        'duration' => '+10 seconds'
    ],
];

Cake\Cache\Cache::config($cache);