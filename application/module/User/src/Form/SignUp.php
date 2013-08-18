<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 15.08.13
 * Time: 15:47
 */
namespace User\Form;

use Zend\Form\Form,
    Zend\Form\FormInterface;

class SignUp extends Form
{
    public function __construct()
    {
        parent::__construct(null, array(

        ));
       $this->setWrapElements(true);
    }

    public function prepareElement(FormInterface $form)
    {
        $this->add(array(
            'name' => 'login',
            'options' => array(
                'label' => 'Login',
            ),
            'attributes' => array(
                'type'  => 'text',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Email',
            'name' => 'email',
            'options' => array(
                'label' => 'Email address',
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Email',
            'name' => 're_email',
            'options' => array(
                'label' => 'Re-type email address',
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password',
            'options' => array(
                'label' => 'Password',
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 're_password',
            'options' => array(
                'label' => 'Re-type password',
            )
        ));
    }
}