<?php

namespace App\Model\Entity;

class User
{
    public $id;
    public $name;
    public $cpf;

    public static function fromArray(Array $data)
    {
        $user = new User();
        $user->setId(isset($data['id']) ? $data['id'] : null);
        $user->setName($data['name']);
        $user->setCpf($data['cpf']);
        return $user;
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
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }
}
