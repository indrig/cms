<?php
namespace User;

use User\Model\UserTable,
    Zend\Mvc\ModuleRouteListener,
    Zend\Mvc\MvcEvent,
    Zend\ServiceManager\ServiceManager,
    Indrig\AbstractModule;

class Module extends AbstractModule
{

    public function onBootstrap(MvcEvent $e)
    {
        parent::onBootstrap($e);

        //Init module tables
        $this->registerTables();

        $eventManager        = $e->getApplication()->getEventManager();
        //$moduleRouteListener = new ModuleRouteListener();
       // $moduleRouteListener->attach($eventManager);
        //
       // exit;
        /**
         * @var \Zend\Authentication\AuthenticationService $Authentication
         */
        $Authentication = $e->getApplication()->getServiceManager()->get('Zend\Authentication\AuthenticationService');


        //var_dump($e->getApplication()->getServiceManager()->get('PluginManager'));

        $authAdapter = $Authentication->getAdapter();

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
				'Authentication' => 'Zend\Authentication\AuthenticationService'
			),
            'factories' => array(
                'User\Adapter\Authentication' => function(ServiceManager $sm)
                {
                    return new Adapter\Authentication($sm->get('table_user'));
                },
                'Zend\Authentication\AuthenticationService' => function(ServiceManager $sm)
                {
                    //$config = $sm->get('Config');
                    $adapter = $sm->get('User\Adapter\Authentication');
                    $authService = new \Zend\Authentication\AuthenticationService(new \Zend\Authentication\Storage\Session(), $adapter);
                    $adapter->initialize($authService);
                    return $authService;
                }
            )
        );

    }



}
