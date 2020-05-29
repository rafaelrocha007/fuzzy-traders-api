<?php

namespace App\Model\Entity;

class Asset
{
    public $id;
    public $name;
    public $type;

    const TYPE_CRYPTOCURRENCY = 'crypto';
    const TYPE_STOCK = 'stock';

    public static function fromArray(array $data)
    {
        $asset = new Asset();
        $asset->setId($data['id']);
        $asset->setName($data['name']);
        $asset->setType($data['type']);
        return $asset;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
