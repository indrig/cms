<?php
namespace Engine;

use Zend\Mvc\MvcEvent,
    Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractModule
{
    /**
     * @var MvcEvent|null
     */
    protected $event = null;
    /**
     * @var null|string
     */
    protected $moduleName = null;

    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager = null;


    /**
     *
     */
    public function __construct()
    {
        //Установка имени модуля
        $controllerClass = get_class($this);
        $this->moduleName = substr($controllerClass, 0, strpos($controllerClass, '\\'));
    }

    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
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
    public function registerTable($class, $alias, $adapter = 'Db\Default', $storageAdapter = 'Cache\Default')
    {
        $this->serviceManager->setFactory($class, function(ServiceLocatorInterface $sm) use ($class, $adapter, $storageAdapter)
        {
            return new $class($sm->get($adapter), $sm->get($storageAdapter));
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

    /**
     * @param $name
     * @return mixed
     */
    protected function service($name)
    {
        return $this->serviceManager->get($name);
    }

    /**
     * @return \Zend\View\HelperPluginManager
     */
    protected function getView()
    {
        return $this->service('ViewHelperManager');
    }

    public function getModuleInfo()
    {

    }

    public function getModulePrivilege()
    {
        return array();
    }

    public function getViewModel()
    {
        return $this->event->getViewModel();
    }
}