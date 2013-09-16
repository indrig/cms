<?php
namespace User\Controller;

use Engine\Controller\AbstractController,
    User\Table\UserList,
    Zend\Mvc\MvcEvent;

class AdminController extends AbstractController
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
        if(!$this->isAllowed('management'))
        {
            return $this->notFoundAction();
        }
        /**
         * @var \Zend\Http\Request $request
         * @var \User\Model\UserTable $table
         * @var \User\Table\UserList $list
         */
        $table = $this->table('user');
        //$list = $userTable->select();
        $request = $this->getRequest();

        $list = new UserList($table, $request);

        if($list->isCustomRender())
        {
            return $this->service('ViewHelperManager')->get('table')->renderContent($list, $this->getResponse());
        }
        else
        {
            return array('list' => $list, 'isSetting' => $this->isAllowed('setting'));
        }
    }

    public function editAction()
    {
        if(!$this->isAllowed('management'))
        {
            return $this->notFoundAction();
        }

        /**
         * @var \Zend\Http\Request $request
         */
        $request = $this->getRequest();

        $user = $this->table('user')->getById($this->params('id'));

        if(!($user instanceof \User\Model\Entity\User))
        {
            return $this->notFoundAction();
        }
        return array('user' => $user);
    }
}
