<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 20.08.13
 * Time: 14:48
 */
namespace Admin;

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

    public function getModulePrivilege()
    {
        return array('read', 'management', 'setting');
    }
}