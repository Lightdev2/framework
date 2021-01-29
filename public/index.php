<?php

use vendor\core\Router;

error_reporting(-1);

$query = rtrim($_SERVER['QUERY_STRING'], '/');

define('WWW', __DIR__);  //текущая директория
define('CORE', dirname(__DIR__) . '/vendor/core');  //директория ядра фрэйморвка
define('ROOT', dirname(__DIR__));  //корневая директория фрэймворка
define('APP', dirname(__DIR__) . '/app');  //директория app
define('LAYOUT', 'default');

require '../vendor/core/Router.php';
require '../vendor/libs/functions.php';

// debug($_GET);

//функция автозагрузки
spl_autoload_register(function ($class) {
    $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

//пользовательские правила
Router::add('^page/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'Page']);
Router::add('^page/(?P<alias>[a-z-]+)$', ['controller' => 'Page', 'action' => 'view']);
//маршруты по умолчанию
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Router::dispatch($query);
