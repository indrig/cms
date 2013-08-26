<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Indrig
 * Date: 19.08.13
 * Time: 23:27
 * To change this template use File | Settings | File Templates.
 */
namespace Indrig\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractController extends AbstractActionController
{
    private $viewHelperManager;


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
}