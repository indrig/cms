<?php
namespace User\Controller;

use Zend\Mvc\MvcEvent,
    Indrig\Controller\AbstractController,
    User\Table\UserList;

class SettingController extends AbstractController
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
