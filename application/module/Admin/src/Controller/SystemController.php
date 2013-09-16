<?php
namespace Admin\Controller;

use Zend\Mvc\MvcEvent,
    Engine\Controller\AbstractController;

class SystemController extends AbstractController
{
    public function onDispatch(MvcEvent $e)
    {
        if(!$this->isAllowed('setting'))
        {
            return $this->notFoundAction();
        }
        return parent::onDispatch($e);
    }

    public function indexAction()
    {

    }
}