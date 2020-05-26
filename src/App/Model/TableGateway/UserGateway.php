<?php

namespace App\Model\TableGateway;

use App\Model\Entity\User;

class UserGateway
{
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function findAll()
    {
        $statement = "SELECT id, name, cpf FROM user;";

        try {
            $statement = $this->conn->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $users = [];
            foreach ($result as $row) {
                $users[] = User::fromDbData($row);
            }
            return $users;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    function find($id)
    {
        $statement = "SELECT id, name, cpf FROM user WHERE id = ?;";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute([$id]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if (count($result))
                return User::fromDbData($result[0]);

            return null;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    function create(User $user)
    {
        $statement = "INSERT INTO user(name, cpf) VALUES (:name, :cpf);";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([
                'name' => $user->getName(),
                'cpf' => $user->getCpf()
            ]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    function update(User $user)
    {
        $statement = "UPDATE user SET name = :name, cpf = :cpf WHERE id = :id;";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute([
                'id' => (int)$user->getId(),
                'name' => $user->getName(),
                'cpf' => $user->getCpf()
            ]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $statement = "DELETE FROM user WHERE id = :id;";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(['id' => $id]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
