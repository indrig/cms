<?php
namespace Admin\Controller;

use Zend\Mvc\MvcEvent,
    Engine\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function onDispatch(MvcEvent $e)
    {
        if(!$this->isAllowed('read'))
        {
            return $this->notFoundAction();
        }
        return parent::onDispatch($e);
    }

    public function indexAction()
    {

    }
}