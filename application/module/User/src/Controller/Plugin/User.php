<?php
namespace User\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin,
    Zend\Mvc\InjectApplicationEventInterface,
    Zend\Mvc\Exception,
    Zend\Mvc\MvcEvent;

class User extends AbstractPlugin
{


    public function __invoke()
    {
        $controller = $this->getController();
        if (!$controller instanceof InjectApplicationEventInterface)
        {
            throw new Exception\DomainException('Url plugin requires a controller that implements InjectApplicationEventInterface');
        }
        $event   = $controller->getEvent();


        if ($event instanceof MvcEvent)
        {
            return $event->getApplication()->getServiceManager()->get('User\Adapter\Authentication');
        }
        return null;
    }
}