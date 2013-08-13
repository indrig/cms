<?php
namespace Main\Model\Entity;

class User
{
    public $id;
    public $login;
    public $password;
    public $salt;

    public function exchangeArray($data)
    {
        $this->id       = (isset($data['id'])) ? $data['id'] : null;
        $this->login    = (isset($data['login'])) ? $data['login'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
        $this->salt     = (isset($data['salt'])) ? $data['salt'] : null;
    }

    public function validatePassword($password)
    {

    }
}
