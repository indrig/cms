<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 15.08.13
 * Time: 15:47
 */
namespace User\Form;

use Zend\Form\Form,
    Zend\Form\FormInterface;

class SignIn extends Form
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
            'type' => 'Password',
            'name' => 'password',
            'options' => array(
                'label' => 'Password',
            )
        ));
        $this->add(array(
            'type' => 'Checkbox',
            'name' => 'quick_expire',
            'options' => array(
                'label' => 'Do not remember me',
                'use_hidden_element' => true,
            )
        ));



    }
}