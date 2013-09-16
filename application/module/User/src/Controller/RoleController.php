<?php
namespace User\Controller;

use Zend\Mvc\MvcEvent,
    Engine\Controller\AbstractController,
    Engine\AbstractModule;

class RoleController extends AbstractController
{
    public function onDispatch(MvcEvent $e)
    {
        if(!$this->isAllowed('setting'))
        {
            return $this->notFoundAction();
        }
        return parent::onDispatch($e);
    }

    public function indexAction()
    {
        /**
         * @var $roleTable \User\Model\RoleTable
         */
        $roleTable = $this->table('role');
        $roles = $roleTable->select();
        return array('roles' => $roles);
    }

    public function createAction()
    {

    }

    public function editAction()
    {

        $id = intval($this->params('id'));
        $result = array();
        /**
         * @var \User\Model\RoleTable $roleTable
         */
        $roleTable = $this->table('role');
        $role = $roleTable->getByID($id);
        if($role === false)
        {
            return $this->notFoundAction();
        }

        /**
         * @var \Zend\ModuleManager\ModuleManager $moduleManager
         * @var \User\Permissions\Acl $acl
         */
        $moduleManager = $this->service('ModuleManager');
        $modules = $moduleManager->getModules();

        /**
         * @var \User\Model\RolePrivilegeTable $rolePrivilegeTable
         */
        $rolePrivilegeTable = $this->table('role_privilege');
        $privileges = $rolePrivilegeTable->getByRollID($role->id);

        //  Сохранение данных
        ///////////////////////////////////////////////////////////////////////
        /**
         * @var \Zend\Http\Request $request
         */
        $request = $this->getRequest();
        if($request->isPost())
        {
            $newPrivileges = array();
            foreach($modules as $moduleName)
            {
                $module = $moduleManager->getModule($moduleName);

                if($module instanceof AbstractModule)
                {
                    $modulePrivileges = $module->getModulePrivilege();

                    foreach($modulePrivileges as $modulePrivilege)
                    {
                        if(intval($request->getPost(strtolower('privilege_'.$moduleName.'_'.$modulePrivilege), 0)) === 1)
                        {
                            $newPrivileges[$moduleName][] = $modulePrivilege;
                        }
                    }
                }
            }
            if($newPrivileges != $privileges)
            {
                $rolePrivilegeTable->beginTransaction();
                try
                {
                    $rolePrivilegeTable->setByRollID($role->id, $newPrivileges);

                    $rolePrivilegeTable->commit();
                    $rolePrivilegeTable->cacheClean();
                }
                catch (\Exception $e)
                {
                    $rolePrivilegeTable->rollback();
                }

            }
            return $this->redirect()->refresh();
        }

        foreach($modules as $moduleName)
        {
            $module = $moduleManager->getModule($moduleName);

            if($module instanceof AbstractModule)
            {
                $result[$moduleName] = array(
                    'privilege'         => $module->getModulePrivilege(),
                    'role_privilege'    => isset($privileges[$moduleName]) ? $privileges[$moduleName] : array()
                );
            }

        }

        return array('result' => $result, 'role' => $role);
    }
}
