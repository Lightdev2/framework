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
     * @var string
     */
    public $layout = '';

    public function __construct(array $route)
    {
        $this->route = $route;
        $this->view = $route['action'];
    }

    public function getView()
    {
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render();
    }
}
