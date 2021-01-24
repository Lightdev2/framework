<?php

/**
 * Класс роутера
 */
class Router
{

    protected static array $routes = [];
    protected static array $route = [];

    /**
     * Добавляет роут в таблицу маршрутизации
     * @param $regexp регулярное выражение
     * @param array $route роут
     */
    public static function add($regexp, array $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    /**
     * Возвращает таблицу маршрутов
     * @return array таблица маршрутов
     */
    public static function getRoutes() : array
    {
        return self::$routes;
    }

    /**
     * Возвращает текущий маршрут
     * @return array текущий маршрут
     */
    public static function getRoute() : array
    {
        return self::$route;
    }

    /**
     * Проверят входит ли запрашиваем url в таблицу маршрутов
     * @param $url запрашиваемый url
     * @return bool
     */
    public static function matchRoute($url) : bool
    {
        foreach(self::$routes as $pattern => $route)
        {
            if($pattern == $url)
            {
                self::$route = $route;
                return true;
            }
        }
        return false;
    }
}
