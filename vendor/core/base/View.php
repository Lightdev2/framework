<?php

namespace vendor\core\base;

class View
{
    /**
     * Текущий маршрут
     * @var array
     */
    public array $route = [];

    /**
     * Текущий вид
     * @var string
     */
    public string $view;

    /**
     * Текущий шаблон
     * @var string
     */
    public string $layout;

    public function __construct(array $route, string $layout = '', string $view = '')
    {
        $this->route = $route;
        $this->layout = $layout ?: LAYOUT;
        $this->view = $view;
    }

    public function render()
    {
        $file_view = APP . "/views/{$this->route['controller']}/{$this->view}.php";
        if (is_file($file_view)) {
            require $file_view;
        } else {
            echo "<p>Не найден вид <b>{$file_view}</b></p>";
        }
    }
}
