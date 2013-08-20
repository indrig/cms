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
        return $this->getServiceLocator()->get('translator')->translate($message);
    }

    public function translateArgs($message, array $args)
    {
        $message = $this->getServiceLocator()->get('translator')->translate($message);
        foreach($args as $k => $v)
        {
            $message = str_replace('%'.$k.'%', $v, $message);
        }
        return $message;
    }

    public function escapeHtml($value)
    {
        $this->viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $this->viewHelperManager->get('escapeHtml'); // $escapeHtml can be called as function because of its __invoke method
        return  $escapeHtml($value);

    }

    /**
     * @param String $name
     * @return \Zend\Db\TableGateway\TableGateway
     */
    public function table($name)
    {
        return $this->getServiceLocator()->get('table_'.$name);
    }
}