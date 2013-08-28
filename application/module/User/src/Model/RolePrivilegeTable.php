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
}