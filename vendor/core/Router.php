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
     * @param string $regexp регулярное выражение
     * @param array $route роут
     * @return void
     */
    public static function add(string $regexp, array $route = [])
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
     * и обновляет текущий роут
     * @param string $url входящий url
     * @return bool
     */
    public static function matchRoute(string $url) : bool
    {
        foreach(self::$routes as $pattern => $route)
        {
            if(preg_match("#$pattern#i", $url, $matches))
            {
                foreach($matches as $key => $value)
                {
                    if(is_string($key))
                    {
                        $route[$key] = $value;
                    }
                }

                if(! isset($route['action']))
                {
                    $route['action'] = 'index';
                }

                self::$route = $route;
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Передает управление в контроллер
     * @param string $url входящий url
     * @return void
     */
    public static function dispatch(string $url) : void
    {
        if(self::matchRoute($url))
        {
            $controller = self::upperCamelCase(self::$route['controller']);

            if(class_exists($controller))
            {
                $cObj = new $controller;
                $action = self::lowerCamelCase(self::$route['action'] . 'Action');
                
                if(method_exists($cObj, $action))
                {
                    $cObj->$action();
                } else {
                    echo "Метод <b>$controller</b>::$action не найден";
                }
            }else {
                echo "Контроллер <b>$controller</b> не найден";
            }
        }else {
            http_response_code(404);
            include '404.html';
        }
    }

    /**
     * Приводит строку к виду ExampleString
     * верхний CamelCase
     * @param string $str строка для преобразования
     * @return string преоборазованная строка
     */
    protected static function upperCamelCase(string $str) : string
    {
        $str = str_replace('-', ' ', $str);
        $str = ucwords($str);
        $str = str_replace(' ', '', $str);
        return $str;
    }

    /**
     * Приводит строку к виду exampleString
     * нижний CamelCase
     * @param string $str строка для преобразования
     * @return string преоборазованная строка
     */
    protected static function lowerCamelCase(string $str) : string
    {
        return lcfirst(self::upperCamelCase($str));
    }
}
