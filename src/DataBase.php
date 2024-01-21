<?php

namespace App;

use PDO;

trait DataBase
{
    private PDO $db;

    public function __construct()
    {
        $this->db = new PDO('sqlite:./db/db.sqlite3');
    }

    public function query(string $query): array
    {
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}