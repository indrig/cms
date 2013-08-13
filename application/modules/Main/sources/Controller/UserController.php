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
        $request = $this->app()->getRequest();

        /**
         * @var $userTable \Main\Model\UserTable
         */
        $userTable = $this->table('user');

        $form = new Form\UserLogin();
        if($request->isPost())
        {
            $login = $request->getPost('login');

            if(($user = $userTable->getByLogin($login)) !== false)
            {
                //Логин не найден
            }

            $form->setAlert('<strong>'.$this->translate('Login failed.').'</strong><br />'.$this->translate('Please make sure that you\'ve entered your login and password correctly.'), 'danger');
        }

        $view = new ViewModel();
        $view->setVariable('form', $form);
        $view->setFile(__DIR__.'/../../view/user/login.phtml');

        return $view;
    }
}