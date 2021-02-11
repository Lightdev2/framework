<?php

namespace vendor\core;

/**
 * Класс для работы с базой данных
 */
class Db
{
    // Объект PDO
    protected $pdo;
    
    // Объект соединения с базой данных
    static protected $instance;

    //Количество SQL запросов
    public static int $countSQL = 0;

    //Массив SQL запросов
    public static array $queries = [];
    /**
     * Вызывается при создании объекта соединения с бд
     * использует PDO для соединения с бд
     * считаывает значения конфигурации из /config/config_db.php
     */
    protected function __construct()
    {
        $db = require ROOT . '/config/config_db.php';
        require LIBS . '/rb.php';
        \R::setup($db['dsn'], $db['user'], $db['pass']);
        \R::freeze( TRUE );
        // \R::fancyDebug( TRUE );
        /**
         * Настройки для PDO
         * режим отображения ошибок
         * получение ассоциативных массивов после выполнения SQL 
         */
        // $options = [
        //     \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        //     \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        // ];
        // $this->pdo = new \PDO($db['dsn'], $db['user'], $db['pass'], $options);
    }

    /**
     * Возвращает объект соединения с бд,
     * если его еще не существует, то создается новый
     * реализует singleton
     */
    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Возвращает true в случае успешного завершения или false в случае возникновения ошибки
     * @param string $sql код SQL для выполнения
     * @param array $params параметры для SQL запроса
     * @return bool
     */
    public function execute(string $sql, array $params = []) : bool
    {
        self::$countSQL++;
        self::$queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * возвращает массив, содержащий все оставшиеся строки результирующего набора.
     * @param string $sql SQL код на выполнение
     * @param array $params параметры для SQL запроса
     * @return array ассоциативный массив
     */
    public function query(string $sql, array $params = []) : array
    {
        self::$countSQL++;
        self::$queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        $res =  $stmt->execute($params);
        if ($res !== false) {
            return $stmt->fetchAll();
        }
        return [];
    }
}