<?php
namespace Content;

use Engine\AbstractModule,
    Zend\Mvc\MvcEvent;

class Module extends AbstractModule
{
    public function __construct()
    {

    }

    /**
     * Listen to the application bootstrap event
     *
     * event manager.
     *
     * @param  \Zend\Mvc\MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
      //  $events = $e->getApplication()->getEventManager();
        //$events->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onRoutePost'), -100);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Страница не найдена
     * @param MvcEvent $e
     */
   /* public function onRoutePost(MvcEvent $e)
    {
        var_dump($e->getRouter());
        exit;
    }*/

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array
            (
                'namespaces' => array
                (
                    __NAMESPACE__ => __DIR__ . '/src/'
                )
            )
        );
    }
}