<?php

namespace App\Model\Entity;

class User
{
    private $id;
    private $name;
    private $cpf;

    public static function fromDbData(array $data){
        $user = new User();
        $user->setId($data['id']);
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
