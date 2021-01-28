<?php

    $query = rtrim($_SERVER['QUERY_STRING'], '/');

    define('WWW', __DIR__);  //текущая директория
    define('CORE', dirname(__DIR__) . '/vendor/core');  //директория ядра фрэйморвка
    define('ROOT', dirname(__DIR__));  //корневая директория фрэймворка
    define('APP', dirname(__DIR__) . '/app');  //директория app

    require '../vendor/core/Router.php';
    require '../vendor/libs/functions.php';

    //функция автозагрузки
    spl_autoload_register(function($class) {
        $file = APP . "/controllers/$class.php";
        if(is_file($file))
        {
            require_once $file;
        }
    });

    //пользовательские правила
    Router::add('^pages/??(?P<action>[a-z-]+)?$', ['controller' => 'Posts', 'action' => 'index']);
    //маршруты по умолчанию
    Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
    Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

    Router::dispatch($query);

    debug(Router::getRoutes());
    debug(Router::getRoute());
