<?php
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
        /**
         * @var \Zend\ModuleManager\ModuleManager $moduleManager
         */
        $moduleManager  = $this->serviceManager->get('moduleManager');
        $modules = $moduleManager->getModules();

        foreach($modules as $moduleName)
        {
            $this->addResource($moduleName);
        }
        $this->initPrivilege();
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
        $list = $table->getAll();
        foreach($list as $id => $role)
        {
            $this->roles[$id] = $role;
            $this->addRole($role);
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
        $privileges = $table->getAll();

        //Применение
        foreach($privileges as $role => $resources)
        {
            try
            {
                foreach($resources as $resource => $allowed)
                {
                    $this->allow($this->roles[$role], $resource, $allowed);
                }
            }catch (\Exception $e)
            {
                //Вобще страно но ресурса такого нет
            }
        }
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

    /**
     * @param  \Zend\Permissions\Acl\Resource\ResourceInterface|string $resource
     * @param  \Zend\Permissions\Acl\Role\RoleInterface|string         $role
     */
    public function getAllPrivilege($role, $resource)
    {
        if(is_string($role))
            $role = $this->getRole($role);

        if(is_string($resource))
            $resource = $this->getResource($resource);


        return $this->roleDFSAllPrivileges($role, $resource);
    }
}