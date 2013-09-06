<?php
namespace User\Controller;

use Core\Controller\AbstractController,
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
        $failure = false;
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
                $adapter->setIdentity($data['email']);
                $adapter->setCredential($data['password']);
                $authenticateResult = $authentication->authenticate();
                if($authenticateResult->isValid())
                {
                    return $this->redirect()->toRoute('user');
                }
                else
                {
                    $failure = true;
                }

            }
        }
        return array('form' => $form, 'failure' => $failure);
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
                $email = $data['email'];
                if($userTable->emailExists($email))
                {
                    $alert = $this->translateArgs('Email %email% already exists', array('email' => $this->escapeHTML($data['email'])));
                }
                else
                {
                    //Попытка регистрации нового пользователя
                    $userTable->register($data['email'], $data['password']);
                    return $this->redirect()->toRoute('user/signin');
                }
            }


        }
        return array('form' => $form, 'alert' => $alert);
    }
}