<?php

namespace vendor\core\base;

abstract class Controller
{

    /**
     * Текущий маршрут и параметры (cntoller, action, params)
     * @var array
     */
    public array $route = [];

    /**
     * Вид
     * @var string
     */
    public string $view;

    /**
     * Текущий вид
     */
    public $layout = '';

    /**
     * Массив пользовательсиких данных
     * @var array
     */
    public array $vars = [];

    public function __construct(array $route)
    {
        $this->route = $route;
        $this->view = $route['action'];
    }

    /**
     * Получает объект вида страницы и осуществляет ее рендер
     */
    public function getView()
    {
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->vars);
    }

    /**
     * Устанавливает переменные в шаблон рендера
     * @param array $vars массив пользовательских данных
     */
    public function set($vars)
    {
        $this->vars = $vars;
    }
}
