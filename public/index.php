<?php

    $query = rtrim($_SERVER['QUERY_STRING'], '/');
    require '../vendor/core/Router.php';
    require '../vendor/libs/functions.php';

    Router::add('posts/add',['controller' => 'posts', 'action' => 'add']);
    Router::add('posts',['controller' => 'posts', 'action' => 'index']);
    Router::add('',['controller' => 'main', 'action' => 'index']);

    debug(Router::getRoutes());

    print($query);

    if(Router::matchRoute($query))
    {
        debug(Router::getRoute());
    } else {
        echo '404';
    }
