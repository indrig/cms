<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 14.08.13
 * Time: 12:33
 */
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    User\Form\SignIn,
    User\Form\SignUp;

class IndexController extends AbstractActionController
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
        return array('form' => $form);
    }
}