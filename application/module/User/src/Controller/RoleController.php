<?php
namespace User\Controller;

use Indrig\Controller\AbstractController;

class RoleController extends AbstractController
{
    public function indexAction()
    {
        /**
         * @var $roleTable \User\Model\RoleTable
         */
        $roleTable = $this->table('role');
        $roles = $roleTable->select();
        return array('roles' => $roles);
    }

    public function createAction()
    {

    }

    public function editAction()
    {

    }
}
