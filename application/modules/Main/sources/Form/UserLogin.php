<?php
namespace Main\Form;

use Core\Web\Form\Form;

class UserLogin extends Form
{
    public function __construct()
    {
        $this->addText('login');
        $this->addPassword('password');
    }
}