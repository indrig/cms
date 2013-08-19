<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 14.08.13
 * Time: 11:18
 */

namespace User\Model;

use Zend\Db\TableGateway\TableGateway,
    Zend\Db\Adapter\AdapterInterface,
    Zend\Db\ResultSet\ResultSet,
    User\Model\Entity\User;

class UserTable extends TableGateway
{
    public function __construct(AdapterInterface $dbAdapter)
    {

        $resultSetPrototype = new ResultSet();

        parent::__construct('user', $dbAdapter);
        $resultSetPrototype->setArrayObjectPrototype(new User('id', $this->table, $this->sql));
        $this->resultSetPrototype = $resultSetPrototype;
    }

    public function getByLogin($login)
    {
        return $this->select(array('login' => $login))->current();
    }

    public function getByID($id)
    {
        return $this->select(array('id' => $id))->current();
    }

    public function loginExists($login)
    {
        return ($this->select(array('login' => $login))->count() > 0);
    }

    /**
     * Insert
     *
     * @param  array $set
     * @return int
     */
    public function insert( $set)
    {
        $this->getAdapter()->getDriver()->getConnection()->beginTransaction();
        try
        {
            $id = parent::insert($set);
            $this->getAdapter()->getDriver()->getConnection()->commit();
            return $id;
        }catch (\Exception $e)
        {
            $this->getAdapter()->getDriver()->getConnection()->rollback();
            return false;
        }
    }
}