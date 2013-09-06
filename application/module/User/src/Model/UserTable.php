<?php
namespace User\Model;

use Zend\Db\TableGateway\TableGateway,
    Zend\Db\Adapter\AdapterInterface,
    Zend\Db\ResultSet\ResultSet,
    Zend\Math\Rand,
    User\Model\Entity\User,
    Zend\Crypt\Password\Bcrypt;

class UserTable extends TableGateway
{
    public function __construct(AdapterInterface $dbAdapter)
    {

        $resultSetPrototype = new ResultSet();

        parent::__construct('user', $dbAdapter);
        $resultSetPrototype->setArrayObjectPrototype(new User('id', $this->table, $this->sql));
        $this->resultSetPrototype = $resultSetPrototype;
    }

    /**
     * @param $login
     * @return Entity\User
     */
    public function getByEmail($email)
    {
        return $this->select(array('email' => $email))->current();
    }

    /**
     * @param $login
     * @return Entity\User
     */
    public function getByID($id)
    {


        return $this->select(array('id' => $id))->current();
    }

    /**
     * @param $login
     * @return Entity\User
     */
    public function emailExists($email)
    {
        return ($this->select(array('email' => $email))->count() > 0);
    }

    /**
     * Регистрация нового пользователя
     * @param string $login
     * @param string $password
     * @return bool|int
     */
    public function register($email, $password)
    {
        //Создания пароля
        try
        {
            $bCrypt         = new Bcrypt();
            $securePassword = $bCrypt->create($password);
        }catch (\Exception $e)
        {
            return false;
        }

        //Внесение изменений в БД
        $this->getAdapter()->getDriver()->getConnection()->beginTransaction();
        try
        {
            $id = parent::insert(array(
                'email'     => $email,
                'password'  => $securePassword,
            ));
            $this->getAdapter()->getDriver()->getConnection()->commit();
            return $id;
        }catch (\Exception $e)
        {
            $this->getAdapter()->getDriver()->getConnection()->rollback();
            return false;
        }
    }
}