<?php
namespace Main\Controller;

use Core\Web\Controller;
use Core\Web\View\Model\ViewModel;

class UserController extends Controller
{
    public function actionIndex()
    {
        echo 'index';
    }

    public function actionSignUp()
    {
        $view = new ViewModel();
        $view->setFile(__DIR__.'/../../view/user/signup.phtml');

        return $view;
    }

    public function actionLogin()
    {
        $view = new ViewModel();
        $view->setFile(__DIR__.'/../../view/user/login.phtml');

        return $view;
    }
}