<?php

namespace App\Model\TableGateway;

use App\Model\Entity\User;

class SessionGateway
{
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function findByCpf($cpf)
    {
        $statement = "SELECT id, name, cpf FROM user WHERE cpf = ?;";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute([$cpf]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if (count($result))
                return User::fromDbData($result[0]);

            return null;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getEntityClass()
    {
        return User::class;
    }
}
