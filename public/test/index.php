<?php

$config = [
    'components' => [
        'cache' => 'classes\Cache',
        'test' => 'classes\Test'
    ]
];


spl_autoload_register(function ($class) {
    $file =  str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

class Registry
{
    public static $objects = [];

    protected static $instance;

    protected function __construct()
    {
        global $config;
        foreach($config['components'] as $name => $component ) {
            self::$objects[$name] = new $component;
        }
    }

    public function __get($name)
    {
        if (is_object(self::$objects[$name])) {
            return self::$objects[$name];
        }
    }

    public function __set($name, $value)
    {
        
    }

    public static function instance()
    {
        if(self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function getList()
    {
        echo '<pre>';
        var_dump(self::$objects);
        echo '</pre>';
    }
}

$app = Registry::instance();

$app->getList();

$app->test->go();