<?php
namespace User\Controller;

use Indrig\Controller\AbstractController,
    User\Table\UserList;

class AdminController extends AbstractController
{
    public function indexAction()
    {
        /**
         * @var \Zend\Http\Request $request
         * @var \User\Model\UserTable $table
         * @var \User\Table\UserList $list
         */
        $table = $this->table('user');
        //$list = $userTable->select();
        $request = $this->getRequest();
//var_dump($request->isXmlHttpRequest());
       // $this->acceptableViewModelSelector()
        $list = new UserList($table, $request);

        if($list->isCustomRender())
        {
            return $list->customRender($this->getResponse());
        }
        else
        {
            return array('list' => $list);
        }
    }

    public function editAction()
    {

    }
}
