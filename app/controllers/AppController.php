<?php

namespace app\controllers;

use vendor\core\base\Controller;

/**
 * Реалзиует общий функционал для контроллеров
 */
class AppController extends Controller
{
    /**
     * @var array массив метаданных;
     */
    public array $meta = [];

    /**
     * Устанавливает мета данные для страницы
     */
    public function setMeta($title = '', $desc = '', $keywords = '')
    {
        $this->meta['title'] = $title;
        $this->meta['desc'] = $desc;
        $this->meta['keywords'] = $keywords;
    }
}
