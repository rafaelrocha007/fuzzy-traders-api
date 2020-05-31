<?php

namespace App\Model\TableGateway;

use App\Model\Entity\Portfolio;
use App\Model\Entity\User;

class PortfolioGateway
{
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function findAll($filter)
    {
        $where = '';
        if ($filter) {
            $where = ' WHERE ';
            $and = '';
            foreach ($filter as $k => $v) {
                $where .= $and . $k . ' = ' . $v;
                $and = ' AND ';
            }
        }

        $statement = "SELECT p.id, userId, assetId, a.name, a.type, amount FROM portfolio p INNER JOIN asset a ON p.assetId = a.id $where;";

        try {
            $statement = $this->conn->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $portifolio = [];
            foreach ($result as $row) {
                $portifolio[] = Portfolio::fromArray($row);
            }
            return $portifolio;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    function find($id)
    {
        $statement = "SELECT id, userId, assetId, amount FROM portfolio WHERE id = ?;";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute([$id]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if (count($result))
                return Portfolio::fromArray($result[0]);

            return null;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    function create($portfolio)
    {
        if (is_array($portfolio)) {
            $portfolio = Portfolio::fromArray($portfolio);
        }

        $statement = "INSERT INTO portfolio(userId, assetId, amount) VALUES (:userId, :assetId, :amount);";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute([
                'userId' => $portfolio->getUserId(),
                'assetId' => $portfolio->getAssetId(),
                'amount' => $portfolio->getAmount()
            ]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    function update($id, $portfolio)
    {
        $oldData = (array) $this->find($id);
        if(is_array($portfolio)){
            $portfolio = Portfolio::fromArray(array_merge($oldData, $portfolio));
        }

        $statement = "UPDATE portfolio SET userId = :userId, assetId = :assetId, amount = :amount WHERE id = :id;";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute([
                'id' => $id,
                'userId' => $portfolio->getUserId(),
                'assetId' => $portfolio->getAssetId(),
                'amount' => $portfolio->getAmount()
            ]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $statement = "DELETE FROM portfolio WHERE id = :id;";

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
        return Portfolio::class;
    }
}
