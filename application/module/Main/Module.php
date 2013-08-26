<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Main;

use Zend\Mvc\ModuleRouteListener,
    Zend\Mvc\MvcEvent,
    Zend\Http\AbstractMessage,
    Indrig\AbstractModule;

class Module extends AbstractModule
{
    public function onBootstrap(MvcEvent $e)
    {
        parent::onBootstrap($e);

        $eventManager           = $e->getApplication()->getEventManager();
        $serviceManager         = $e->getApplication()->getServiceManager();
        $moduleRouteListener    = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $translator = $serviceManager->get('translator');
        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);

        $eventManager->attach(MvcEvent::EVENT_FINISH,
            function(MvcEvent $e)
            {
                $response = $e->getResponse();
                if ($response instanceof AbstractMessage)
                {

                    $response->getHeaders()->addHeaders(array(
                        'X-Powered-By'  => 'Nashny CMS',
                        'Server'        => 'Nashny Script'
                    ));
                }
            }, 500);


    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

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
