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
    Zend\Math\Rand,
    User\Model\Entity\Role;

class RoleTable extends TableGateway
{
    public function __construct(AdapterInterface $dbAdapter)
    {
        $resultSetPrototype = new ResultSet();

        parent::__construct('role', $dbAdapter);
        $resultSetPrototype->setArrayObjectPrototype(new Role('id', $this->table, $this->sql));
        $this->resultSetPrototype = $resultSetPrototype;
    }
}