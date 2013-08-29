<?php
namespace User\Model;

use Indrig\Db\TableGateway,
    Zend\Db\Adapter\AdapterInterface,
    Zend\Db\ResultSet\ResultSet,
    Zend\Math\Rand;

class RolePrivilegeTable extends TableGateway
{
    public function __construct(AdapterInterface $dbAdapter)
    {
        //$resultSetPrototype = new ResultSet();

        parent::__construct('role_privilege', $dbAdapter);

        //$resultSetPrototype->setArrayObjectPrototype(new RolePrivilege(array(), $this->table, $this->sql));
        //$this->resultSetPrototype = $resultSetPrototype;
    }

    /**
     * @param $role_id
     * @return array
     */
    public function getByRollID($role_id, $resource = null)
    {
        $privileges = array();
        if($resource === null)
        {
            $result = $this->select(array('role_id' => $role_id));
            foreach($result as $row)
            {
                $privileges[$row->resource][] = $row->privilege;
            }
        }
        else
        {
            $result = $this->select(array('role_id' => $role_id, 'resource' => $resource));
            foreach($result as $row)
            {
                $privileges[] = $row->privilege;
            }
        }

        return $privileges;
    }

    public function deleteByRollID($role_id)
    {
        return $this->delete(array('role_id' => $role_id));
    }

    public function setByRollID($role_id, array $set)
    {
        $this->deleteByRollID($role_id);
        foreach($set as $resource => $privileges)
        {
            foreach($privileges as $privilege)
            {
              //  var_dump($privilege);
                $this->insert(array('role_id'=> $role_id, 'resource' => $resource, 'privilege' => $privilege));
            }
        }
    }
}