<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 14.08.13
 * Time: 11:18
 */

namespace User\Model;

use Indrig\Db\TableGateway,
    Zend\Db\Adapter\AdapterInterface,
    Zend\Db\ResultSet\ResultSet,
    Zend\Math\Rand,
    User\Model\Entity\RolePrivilege;

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