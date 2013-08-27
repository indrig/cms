<?php
namespace SiteMap;

use Indrig\AbstractModule;

class Module extends AbstractModule
{
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