<?php
namespace User\Model;

use Engine\Db\TableGateway,
    Zend\Db\Adapter\AdapterInterface,
    Zend\Db\ResultSet\ResultSet,
    Zend\Math\Rand,
    Zend\Cache\Storage\StorageInterface,
    User\Model\Entity\Role;

class RoleTable extends TableGateway
{
    public function __construct(AdapterInterface $dbAdapter, StorageInterface $storageAdapter )
    {
        $resultSetPrototype = new ResultSet();

        parent::__construct('role', $dbAdapter, $storageAdapter);

        $resultSetPrototype->setArrayObjectPrototype(new Role('id', $this->table, $this->sql));
        $this->resultSetPrototype = $resultSetPrototype;
    }

    /**
     * @param $id
     *
     */
    public function getByID($id)
    {
       return $this->select(array('id' => $id))->current();
    }

    public function getAll()
    {
        $cache = $this->cacheGet('role_all');

        if(is_array($cache))
        {
            return $cache;
        }
        else
        {
            $data = array();
            $result = $this->select();

            foreach($result as $role)
            {
                $data[$role->id] = $role->name;
            }
            $this->cacheSet('role_all', $data);
            return $data;
        }
    }


    public function cacheClean()
    {
        $this->cacheRemove('role_all');
    }
}