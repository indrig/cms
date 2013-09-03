<?php
namespace Core\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractController extends AbstractActionController
{
    protected $viewHelperManager;
    protected $moduleName;
    public function __construct()
    {

        $controllerClass = get_class($this);
        $this->moduleName = substr($controllerClass, 0, strpos($controllerClass, '\\'));

    }

    public function translate($message)
    {
        return $this->service('translator')->translate($message);
    }

    public function translateArgs($message, array $args)
    {
        $message = $this->service('translator')->translate($message);
        foreach($args as $k => $v)
        {
            $message = str_replace('%'.$k.'%', $v, $message);
        }
        return $message;
    }

    public function escapeHtml($value)
    {
        $this->viewHelperManager = $this->service('ViewHelperManager');
        $escapeHtml = $this->viewHelperManager->get('escapeHtml'); // $escapeHtml can be called as function because of its __invoke method
        return  $escapeHtml($value);
    }

    /**
     * Получение интерфейса таблицы
     *
     * @param String $name
     * @return \Zend\Db\TableGateway\TableGateway
     */
    public function table($name)
    {
        return $this->service('table_'.$name);
    }

    /**
     * Получение сервиса
     *
     * @param $name
     * @return array|object
     */
    public function service($name)
    {
        return $this->getServiceLocator()->get($name);
    }

    /**
     * @param null $name
     * @return \Zend\Cache\Storage\Adapter\AbstractAdapter
     */
    public function cache($name = null)
    {
        return $this->service('Cache\Default');
    }

    /**
     * Проверяет если прова на делйствия для данного модуля
     *
     * @param $privilege
     * @return mixed
     */
    protected function isAllowed($privilege)
    {

        return $this->user()->isAllowed($this->moduleName, $privilege);
    }
}