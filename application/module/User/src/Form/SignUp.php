<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 15.08.13
 * Time: 15:47
 */
namespace User\Form;

use Zend\Form\Form;

class SignUp extends Form
{
    public function prepareElements()
    {
        // add() can take either an Element/Fieldset instance,
        // or a specification, from which the appropriate object
        // will be built.

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
                'label' => 'Your email address',
            ),

        ));
    }
}