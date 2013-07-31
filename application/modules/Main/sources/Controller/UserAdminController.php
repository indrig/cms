<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 15:55
 */
namespace Main\Controller;

use Core\Web\Controller;

class UserAdminController extends Controller
{
    public function actionIndex()
    {
        echo 'index';
    }

    public function actionEdit()
    {
        echo 'edit';
    }

    public function actionDelete()
    {
        echo 'delete';
    }
}