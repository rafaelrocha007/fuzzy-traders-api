<?php

namespace App\Model\Entity;

class Portfolio
{
    public $id;
    public $userId;
    public $assetId;
    public $amount;

    public static function fromArray(Array $data)
    {
        $portfolio = new Portfolio();
        $portfolio->setId(isset($data['id']) ? $data['id'] : null);
        $portfolio->setUserId($data['userId']);
        $portfolio->setAssetId($data['assetId']);
        $portfolio->setAmount($data['amount']);

        //data from asset included for getAll
        $portfolio->name = $data['name'] ?? null;
        $portfolio->type = $data['type'] ?? null;
        return $portfolio;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getAssetId()
    {
        return $this->assetId;
    }

    /**
     * @param mixed $asset
     */
    public function setAssetId($assetId)
    {
        $this->assetId = $assetId;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}
