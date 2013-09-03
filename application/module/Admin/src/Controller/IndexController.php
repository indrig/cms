<?php
/**
 * User: Igor Bubnevich aka Core
 * Date: 27.08.13
 * Time: 12:28
 */
namespace Admin\Controller;

use Zend\Mvc\MvcEvent,
    Core\Controller\AbstractController;

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