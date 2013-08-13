<?php
namespace Main\Form;

use Core\Web\Form\Form;

class UserSignUp extends Form
{
    public function __construct()
    {
        $this->addText('login', array(
            'label' => 'Login',
            'attributes' => array(
                'required' => true
            )
        ));

        $this->addText('first_name', array(
            'label' => 'First name',
            'attributes' => array(

            )
        ));
        $this->addText('last_name', array(
            'label' => 'Last name',
            'attributes' => array(
            )
        ));
    }
}