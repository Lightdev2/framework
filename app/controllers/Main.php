<?php

namespace app\controllers;

class Main extends App
{
    public $layout = 'main';

    public function indexAction()
    {
        $name = 'pepega';
        $this->set(['name' => 'pepega', 'hi' => 'Hello,world!']);
    }
}
