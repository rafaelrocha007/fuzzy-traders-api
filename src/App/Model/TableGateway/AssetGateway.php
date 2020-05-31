<?php

namespace App\Model\TableGateway;

use App\Model\Entity\Asset;

class AssetGateway
{
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function findAll()
    {
        $statement = "SELECT id, name, type FROM asset;";

        try {
            $statement = $this->conn->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $assets = [];
            foreach ($result as $row) {
                $assets[] = Asset::fromArray($row);
            }
            return $assets;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    function find($id)
    {
        $statement = "SELECT id, name, type FROM asset WHERE id = ?;";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute([$id]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if (count($result))
                return Asset::fromArray($result[0]);

            return null;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    function create(Asset $asset)
    {
        $statement = "INSERT INTO asset(name, type) VALUES (:name, :type);";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute([
                'name' => $asset->getName(),
                'type' => $asset->gettype()
            ]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    function update(Asset $asset)
    {
        $statement = "UPDATE asset SET name = :name, type = :type WHERE id = :id;";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute([
                'id' => (int)$asset->getId(),
                'name' => $asset->getName(),
                'type' => $asset->gettype()
            ]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $statement = "DELETE FROM asset WHERE id = :id;";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(['id' => $id]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getEntityClass()
    {
        return Asset::class;
    }
}
