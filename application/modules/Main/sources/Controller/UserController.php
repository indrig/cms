<?php
namespace Main\Controller;

use Core\Web\Controller,
    Core\Web\View\Model\ViewModel,
    Main\Form;

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
        $form = new Form\UserLogin();

        $view = new ViewModel();
        $view->setVariable('form', $form);
        $view->setFile(__DIR__.'/../../view/user/login.phtml');

        return $view;
    }
}