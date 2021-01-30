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

    public function __construct(array $route, $layout = '', string $view = '')
    {
        $this->route = $route;
        //проверка нужно ли рендерить шаблон
        if ($layout === false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }

        $this->view = $view;
    }

    /**
     * Рендерит страницу
     * @param array $vars пользовательские данные
     */
    public function render($vars)
    {
        //распаковка пользовательских данных
        extract($vars);
        /**
         * Путь до файла вида
         * @var string
         */
        $file_view = APP . "/views/{$this->route['controller']}/{$this->view}.php";

        //включение буферизации вывода
        ob_start();

        if (is_file($file_view)) {
            require $file_view;
        } else {
            echo "<p>Не найден вид <b>{$file_view}</b></p>";
        }

        /**
         * Получить содержимое текущего буфера
         * в переменную $content и удалить его
         */
        $content = ob_get_clean();

        //отрисовка шаблона если он не отключен
        if (false != $this->layout) {
            /**
             * @var string путь до файла шаблона
             */
            $file_layout = APP . "/views/layouts/{$this->layout}.php";

            //отрисовка шаблона
            if (is_file($file_layout)) {
                require $file_layout;
            } else {
                echo $this->layout;
                echo "<p>Не найден шаблон <b>{$file_layout}</b></p>";
            }
        }
    }
}
