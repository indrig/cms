<?php
namespace SiteMap;

use Engine\AbstractModule;
use Zend\Mvc\MvcEvent;

class Module extends AbstractModule
{
    public function onBootstrap(MvcEvent $e)
    {


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