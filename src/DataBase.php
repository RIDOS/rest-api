<?php

namespace App;

use PDO;

/**
 * Очень простой трейт для работы с базой данных sqlite.
 * 
 * Используется в репозирории.
 */
trait DataBase
{
    private PDO $db;

    /**
     * Подключение к базе данных.
     */
    public function __construct()
    {
        $this->db = new PDO('sqlite:./db/db.sqlite3');
    }

    /**
     * Выполнение запроса.
     * 
     * @param string $query Запрос в базу данных.
     * 
     * @return array Ассоциативный массив.
     */
    public function query(string $query): array
    {
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}