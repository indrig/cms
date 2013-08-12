<?php
namespace Main\Form;

use Core\Web\Form\Form;

class UserLogin extends Form
{
    public function __construct()
    {
        $this->addText('login', array(
            'label' => 'Login',
            'attributes' => array(
                'required' => true
            )
        ));
        $this->addPassword('password', array('label' => 'Password'));
        $this->addCheckbox('expire', array('label' => 'Do not remember me'));
        /**
         * @var \Core\Web\Form\Element\Inline $footerButtons
         */
        $footerButtons = $this->addInline();

        $footerButtons->addElement($this->createSubmit('signin', array('label' => 'Sign In')));
        $footerButtons->addElement($this->createButton('signup', array('label' => 'Sign Up', 'buttonstyle' => 'link')));
    }
}