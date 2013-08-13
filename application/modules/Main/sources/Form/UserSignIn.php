<?php
namespace Main\Form;

use Core\Web\Form\Form;

class UserSignIn extends Form
{
    public function __construct()
    {
        $this->addText('login', array(
            'label' =>  $this->translate('Login'),
            'attributes' => array(
                'required' => true
            )
        ));
        $this->addPassword('password', array('label' => $this->translate('Password')));
        $this->addCheckbox('expire', array('label' => $this->translate('Do not remember me')));
        /**
         * @var \Core\Web\Form\Element\Inline $footerButtons
         */
        $footerButtons = $this->addInline();

        $footerButtons->addElement($this->createSubmit('signin', array('label' =>  $this->translate('Sign In'))));
        $footerButtons->addElement($this->createButton('signup', array('label' =>  $this->translate('Sign Up'), 'buttonstyle' => 'link')));
    }
}