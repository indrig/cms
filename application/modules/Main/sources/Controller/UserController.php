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
        $request = $this->app()->getRequest();
        var_dump($request->getPreferredLanguages());
        $form = new Form\UserSignUp();
        if($request->isPost())
        {

        }
        return array('form' => $form);
    }

    public function actionSignIn()
    {
        $request = $this->app()->getRequest();

        $form = new Form\UserSignIn();
        if($request->isPost())
        {
            /**
            * @var $userTable \Main\Model\UserTable
            */
            $userTable = $this->table('user');
            $login = $request->getPost('login');

            if(($user = $userTable->getByLogin($login)) !== false)
            {
                //Логин не найден
            }

            $form->setAlert('<strong>'.$this->translate('Login failed.').'</strong><br />'.$this->translate('Please make sure that you\'ve entered your login and password correctly.'), 'danger');
        }
        return array('form' => $form);
    }

    public function actionSignOut()
    {

    }
}