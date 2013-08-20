<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 20.08.13
 * Time: 10:08
 */
namespace Indrig;

use Zend\Mvc\MvcEvent,
    Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractModule
{
    /**
     * @var MvcEvent|null
     */
    protected $event = null;

    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager = null;
    public function onBootstrap(MvcEvent $e)
    {
        $this->event = $e;
        $this->serviceManager = $e->getApplication()->getServiceManager();
    }

    /**
     * @param string $class
     * @param string|null $alias
     * @param string $adapter
     */
    public function registerTable($class, $alias, $adapter = 'database')
    {
        $this->serviceManager->setFactory($class, function(ServiceLocatorInterface $sm) use ($class, $adapter)
        {
            return new $class($sm->get($adapter));
        });
        if(is_string($alias))
        {
            $this->serviceManager->setAlias('table_'.$alias, $class);
        }
    }

    /**
     * @param String $name
     * @return \Zend\Db\TableGateway\TableGateway
     */
    public function table($name)
    {
        return $this->serviceManager->get('table_'.$name);
    }
}