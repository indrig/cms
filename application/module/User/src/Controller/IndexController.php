<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 14.08.13
 * Time: 12:33
 */
namespace User\Controller;

use Main\Controller\AbstractController,
    User\Form\SignIn,
    User\Form\SignUp;

class IndexController extends AbstractController
{
    public function indexAction()
    {


    }

    public function signOutAction()
    {


    }

    public function signInAction()
    {
        $form = new SignIn();
        return array('form' => $form);
    }

    public function signUpAction()
    {

        $form = new SignUp();
        $form->prepare();
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
                $userTable = $this->getServiceLocator()->get('User\Model\UserTable');

                $login = $form->get('login')->getValue();
                if($userTable->loginExists($login))
                {
                    $alert = $this->translateArgs('Login %login% already exists', array('login' => $this->escapeHTML($login)));
                }
                else
                {
                    $userTable->insert(
                        array(
                            'login' => $login,
                            'email' => $form->get('email')->getValue()
                        )
                    );
                }
            }


        }
        return array('form' => $form, 'alert' => $alert);
    }
}