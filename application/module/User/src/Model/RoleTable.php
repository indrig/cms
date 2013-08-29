<?php
namespace User\Model;

use Indrig\Db\TableGateway,
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

    /**
     * @param $id
     *
     */
    public function getByID($id)
    {
       return $this->select(array('id' => $id))->current();
    }


}