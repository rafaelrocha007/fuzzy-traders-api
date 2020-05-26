<?php

namespace App\Database;

use PDOException;

class Connector
{

    private $conn = null;

    public function __construct()
    {
        try {

            $this->conn =  new \PDO(
                'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';charset=utf8mb4;dbname=' . getenv('DB_NAME'),
                getenv('DB_USER'),
                getenv('DB_PASS')
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
