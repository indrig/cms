<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Indrig
 * Date: 20.08.13
 * Time: 22:32
 * To change this template use File | Settings | File Templates.
 */
namespace User\Permissions;

use Zend\Permissions\Acl\Acl as ZendAcl,
    Zend\ServiceManager\ServiceLocatorInterface;

class Acl extends ZendAcl
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager = null;
    protected $roles = array();

    public function __construct(ServiceLocatorInterface $sm)
    {
        $this->serviceManager = $sm;

        $this->initRole();
       // $this->initPrivilege();
    }

    /**
     * Установка ролей
     */
    protected function initRole()
    {
        /**
         * @var \User\Model\RoleTable $table
         */

        $table = $this->serviceManager->get('table_role');

        /**
         * @var \Zend\Db\ResultSet\ResultSet
         */
        $list = $table->all();
        foreach($list as $role)
        {
            $this->roles[$role->id] = $role->name;
            $this->addRole($role->name);
        }
    }

    /**
     * Установка привелегий
     */
    protected function initPrivilege()
    {
        /**
         * @var \User\Model\RolePrivilegeTable $table
         */
        $table = $this->serviceManager->get('table_role_privilege');
        $list = $table->all();

        //Формирование списка ролей
        $privileges = array();
        foreach($list as $privilege)
        {
            if(isset($this->roles[$privilege->role_id]))
                $privileges[$this->roles[$privilege->role_id]][$privilege->resource][] = $privilege->privilege;
        }

        //Применение
        foreach($privileges as $role => $resources)
        {
            foreach($resources as $resource => $allowed)

            $this->allow($role, $resource, $allowed);
        }
    }

    public function initialize()
    {
        $this->initPrivilege();
    }
    /**
     * @param array $ids
     * @return array|null
     */
    public function rolesFotUser(array $ids)
    {
        if(sizeof($ids) > 0)
        {
            $parent = array();
            foreach($ids as $id)
            {
                if(isset($this->roles[$id]))
                    $parent[] = $this->roles[$id];
            }
            return $parent;
        }

        return null;
    }

    /**
     * @param $user_role
     * @param \Zend\Permissions\Acl\Role\RoleInterface|string $role $role
     * @return array
     */
    public function hasRoleUser($user_role, $role)
    {
        $parents = $this->getRoleRegistry()->getParents($user_role);
        return isset($parents[$role]);
    }
}