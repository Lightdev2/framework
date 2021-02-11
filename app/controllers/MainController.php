<?php

namespace app\controllers;

use app\models\Main;

class MainController extends AppController
{

    public function indexAction()
    {
        $model = new Main;
        $this->setMeta('Main page', 'Описание страницы', 'Ключевые слова');
        $meta = $this->meta;
        $this->set(compact('meta'));
    }
}
