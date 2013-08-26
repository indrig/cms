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
    User\Model\Entity\UserRole;

class UserRoleTable extends TableGateway
{
    public function __construct(AdapterInterface $dbAdapter)
    {
        $resultSetPrototype = new ResultSet();

        parent::__construct('user_role', $dbAdapter);

        $resultSetPrototype->setArrayObjectPrototype(new UserRole(array('user_id', 'role_id'), $this->table, $this->sql));
        $this->resultSetPrototype = $resultSetPrototype;
    }

    /**
     * Получение списка ролей для юзера
     * @param int $user_id
     * @return array
     */
    public function getForUserId($user_id)
    {
        $roles = array();
        $result = $this->select(array('user_id' => $user_id));
        foreach($result as $userRole)
        {
            $roles[] = $userRole->role_id;
        }
        return $roles;
    }
}