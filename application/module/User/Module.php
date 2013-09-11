<?php
namespace User;

use User\Model\UserTable,
    Zend\Mvc\ModuleRouteListener,
    Zend\Mvc\MvcEvent,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\ModuleManager\ModuleManagerInterface,
    Core\AbstractModule,
    Zend\Console\Console;

class Module extends AbstractModule
{
    public function onBootstrap(MvcEvent $e)
    {
        parent::onBootstrap($e);

        if(!Console::isConsole())
        {
             /**
             * @var \User\Adapter\Authentication $Authentication
             */
            $Authentication = $this->service('Authentication');
            $Authentication->initialize();

            //Установка ролей для навигации
            ///////////////////////////////////////////////////////////////////////
            \Zend\View\Helper\Navigation\AbstractHelper::setDefaultAcl($this->service('Acl'));
            if(($role = $Authentication->getRole()) !== false)
            {
                \Zend\View\Helper\Navigation\AbstractHelper::setDefaultRole($role);
            }
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }



    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/'
                )
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
				'AuthenticationService'     => 'Zend\Authentication\AuthenticationService',
				'Authentication'            => 'User\Adapter\Authentication',
				'Acl'                       => 'User\Permissions\Acl',
                //
                'table_user'                => 'User\Model\UserTable',
                'table_role'                => 'User\Model\RoleTable',
                'table_user_role'           => 'User\Model\UserRoleTable',
                'table_role_privilege'      => 'User\Model\RolePrivilegeTable',
			),
            'factories' => array(
                //Авторизация
                'User\Adapter\Authentication' => function(ServiceLocatorInterface $sm)
                {
                    return new Adapter\Authentication($sm);
                },
                'Zend\Authentication\AuthenticationService' => function(ServiceLocatorInterface $sm)
                {
                    $adapter = $sm->get('Authentication');
                    $authService = new \Zend\Authentication\AuthenticationService(new \Zend\Authentication\Storage\Session(), $adapter);
                    return $authService;
                },
                'User\Permissions\Acl' => function(ServiceLocatorInterface $sm)
                {
                    return new Permissions\Acl($sm);
                },

                //  Таблицы
                ///////////////////////////////////////////////////////////////
                'User\Model\UserTable' => function(ServiceLocatorInterface $sm)
                {
                    return new \User\Model\UserTable($sm->get('Db\Default'));
                },
                'User\Model\RoleTable' => function(ServiceLocatorInterface $sm)
                {
                    return new \User\Model\RoleTable($sm->get('Db\Default'), $sm->get('Cache\Default'));
                },
                'User\Model\UserRoleTable' => function(ServiceLocatorInterface $sm)
                {
                    return new \User\Model\UserRoleTable($sm->get('Db\Default'));
                },
                'User\Model\RolePrivilegeTable' => function(ServiceLocatorInterface $sm)
                {
                    return new \User\Model\RolePrivilegeTable($sm->get('Db\Default'), $sm->get('Cache\Default'));
                }
            )
        );

    }

    public function getModulePrivilege()
    {
        return array('management', 'setting');
    }

}
