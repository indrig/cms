<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 14.08.13
 * Time: 12:33
 */
namespace User\Controller;

use Indrig\Controller\AbstractController,
    Zend\Authentication\Result,
    User\Form\SignIn,
    User\Form\SignUp;

class IndexController extends AbstractController
{
    public function indexAction()
    {
        if($this->Identity() === null)
        {
            return $this->redirect()->toRoute('user/signin');
        }


    }

    /**
     * Выход из ситемы
     * @return \Zend\Http\Response
     */
    public function signOutAction()
    {
        $authentication = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authentication->clearIdentity();
        return $this->redirect()->toRoute('home');
    }

    /**
     * Вход в систему
     * @return array|\Zend\Http\Response
     */
    public function signInAction()
    {
        if($this->Identity() !== null)
        {
            return $this->redirect()->toRoute('user');
        }

        /**
        * @var \Zend\Http\Request $request
        * @var \User\Model\UserTable $userTable

        */
        $form = new SignIn();

        $request = $this->getRequest();
        if ($request->isPost())
        {
            $form->setData($request->getPost());

            if($form->isValid())
            {
                $userTable = $this->table('user');
                $data = $form->getData();

                $authentication = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

                $adapter = $authentication->getAdapter();
                $adapter->setIdentity($data['login']);
                $adapter->setCredential($data['password']);
                $authenticateResult = $authentication->authenticate();
                if($authenticateResult->isValid())
                {
                    return $this->redirect()->toRoute('user');
                }

            }
        }
        return array('form' => $form);
    }

    /**
     * Регистрация нового пользователя
     * @return array|\Zend\Http\Response
     */
    public function signUpAction()
    {
        if($this->Identity() !== null)
        {
            return $this->redirect()->toRoute('user');
        }

        $form = new SignUp();

        /**
         * @var \Zend\Http\Request $request
         */
        $alert = false;
        $request = $this->getRequest();
        if ($request->isPost())
        {

           // $form->inputFilter();

            $form->setData($request->getPost());

            if($form->isValid())
            {
                /**
                 * @var \User\Model\UserTable $userTable
                 */
                $userTable = $this->table('user');
                $data = $form->getData();
                //Проверка логина на уникальность
                $login = $data['login'];
                if($userTable->loginExists($login))
                {
                    $alert = $this->translateArgs('Login %login% already exists', array('login' => $this->escapeHTML($data['login'])));
                }
                else
                {
                    //Попытка регистрации нового пользователя
                    $userTable->register($data['login'], $data['password']);
                }
            }


        }
        return array('form' => $form, 'alert' => $alert);
    }
}