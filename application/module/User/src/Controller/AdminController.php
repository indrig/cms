<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Indrig
 * Date: 20.08.13
 * Time: 22:54
 * To change this template use File | Settings | File Templates.
 */
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

            for($i = 0; $i < 20; $i++)
            {
                $a[] = array($i, $i);
            }

            return $this->getResponse()->setContent(json_encode(array(
                'data' => $a,
                'count' => 112,
                'limit' => 10
            )));
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
