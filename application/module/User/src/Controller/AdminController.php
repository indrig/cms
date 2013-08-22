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
        $userTable = $this->table('user');
        $list = $userTable->select();
        $userList = new UserList($userTable);
        return array('list' => $userList);
    }

    public function editAction()
    {

    }
}
