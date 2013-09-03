<?php
/**
 * User: Igor Bubnevich aka Core
 * Date: 14.08.13
 * Time: 11:26
 */
namespace User\Model\Entity;

use Zend\Db\RowGateway\RowGateway,
    Zend\Crypt\Password\Bcrypt;

class User extends RowGateway
{
    /**
     * @param $password
     * @return bool
     */
    public function verifyPassword($password)
    {
        $bCrypt = new Bcrypt();
        return $bCrypt->verify($password, $this->password);
    }

    public function screenName()
    {
        return $this->login;
    }
}