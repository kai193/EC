<?php

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:charset=UTF8;
            dbname=ph16_diary;host=localhost',
            'root',
            'root'
        );
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
