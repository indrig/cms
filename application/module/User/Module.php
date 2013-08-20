<?php
namespace User;

use User\Model\UserTable,
    Zend\Mvc\ModuleRouteListener,
    Zend\Mvc\MvcEvent,
    Zend\ServiceManager\ServiceLocatorInterface,
    Indrig\AbstractModule;

class Module extends AbstractModule
{

    public function onBootstrap(MvcEvent $e)
    {
        parent::onBootstrap($e);

        //Init module tables
        $this->registerTables();

        $eventManager        = $e->getApplication()->getEventManager();

       // exit;
        /**
         * @var \Zend\Authentication\AuthenticationService $Authentication
         */

        $serviceManager = $e->getApplication()->getServiceManager();
        $serviceManager->get('Authentication')->initialize($serviceManager);
       // $Authentication = $e->getApplication()->getServiceManager()->get('AuthenticationService');


        //var_dump($e->getApplication()->getServiceManager()->get('PluginManager'));

       // $authAdapter = $Authentication->getAdapter();

        /*$eventManager->attach(MvcEvent::EVENT_ROUTE, function(MvcEvent $e)
        {
           // $auth = new AuthenticationService();
           // $is_login = $auth->hasIdentity();

            $routeParams = $e->getRouteMatch();

        });*/

    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function registerTables()
    {
        $this->registerTable('\User\Model\UserTable', 'user');
        $this->registerTable('\User\Model\RoleTable', 'role');
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
				'Acl'                       => 'User\Permissions\Acl'
			),
            'factories' => array(
                'User\Adapter\Authentication' => function(ServiceLocatorInterface $sm)
                {
                    return new Adapter\Authentication($sm->get('table_user'));
                },
                'Zend\Authentication\AuthenticationService' => function(ServiceLocatorInterface $sm)
                {
                    $adapter = $sm->get('User\Adapter\Authentication');
                    $authService = new \Zend\Authentication\AuthenticationService(new \Zend\Authentication\Storage\Session(), $adapter);
                    return $authService;
                },
                'User\Permissions\Acl' => function(ServiceLocatorInterface $sm)
                {
                    return new Permissions\Acl();
                }
            )
        );

    }



}
