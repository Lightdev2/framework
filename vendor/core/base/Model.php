<?php

namespace vendor\core\base;

use vendor\core\Db;

/**
 * Базовый класс для моделей
 */
abstract class Model
{
    /**
     * Объект соединения с бд
     */ 
    protected $pdo;

    /**
     * Таблица для работы
     */
    protected $table;

    /**
     * Поле первичного ключа
     * @var string id по умолчанию
     */
    protected $pk = 'id';


    /**
     * При создании объекта модели, в перменную $pdo 
     * записывается объект соединения с бд
     */
    public function __construct()
    {
        $this->pdo = Db::instance(); 
    }

    /**
     * Возвращает true/false в зависимости
     * от результат выполнения SQL кода
     * @param string $sql SQL код на выполнение
     * @return bool
     */
    public function query(string $sql) : bool
    {
        return $this->pdo->execute($sql);
    }

    /**
     * Возвращает все строки из таблицы
     * @return array
     */
    public function findAll() : array
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql);
    }

    /**
     * Находит одну запись
     * @param mixed $id критерий отбора
     * @param string $field столбец по которому происходит отбор, по умолчанию id
     * @return array возвращает ассоциативный массив с результатом
     */
    public function findOne($id, string $field = '') : array
    {
        $field = $field ?: $this->pk;
        $sql = "SELECT * FROM {$this->table} WHERE $field = ? LIMIT 1";
        return $this->pdo->query($sql, [$id]);
    }

    /**
     * Находит строки с помощью кастомного SQL запроса
     * @param string $sql код SQL запроса
     * @param $params параметры для SQL запроса
     * @return array результирующий набор
     */
    public function findBySql(string $sql, array $params = []) : array
    {
        return $this->pdo->query($sql, $params);
    }

    /**
     * Возвращает резуьтируюши набор, соотв регулярному выражению SQL
     * @param string $str регулярное выражение
     * @param string $field поле по кторому осуществляется поиск
     * @param $table таблицы для запроса
     * @return array
     */
    public function findLike(string $str, string $field, $table = '')
    {
        $table = $table ?: $this->table;
        $sql = "SELECT * FROM $table WHERE $field LIKE ?";
        return $this->pdo->query($sql, ['%' . $str . '%']);
    }
}