<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 15.08.13
 * Time: 15:47
 */
namespace User\Form;

use Zend\Form\Form,
    Zend\Form\FormInterface,
    Zend\InputFilter\Factory,     // <-- Add this import
    Zend\InputFilter\InputFilter,                 // <-- Add this import
    Zend\InputFilter\InputFilterAwareInterface,   // <-- Add this import
    Zend\InputFilter\InputFilterInterface;       // <-- Add this import


class SignUp extends Form
{
    private $inputFilter;

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
                'lg'    => 5
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
                'lg'    => 5
            )
        ));
       /* $this->add(array(
            'type' => 'Zend\Form\Element\Email',
            'name' => 're_email',
            'options' => array(
                'label' => 'Re-type email address',
                'lg'    => 5
            )
        ));*/
        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password',
            'options' => array(
                'label' => 'Password',
                'lg'    => 5
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 're_password',
            'options' => array(
                'label' => 'Re-type password',
                'lg'    => 5
            )
        ));
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter)
        {

            $inputFilter = new InputFilter();
            $factory     = new Factory();

            //Логин
            $inputFilter->add($factory->createInput(array(
                'name'     => 'login',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));
            //Почта
            $inputFilter->add($factory->createInput(array(
                'name'     => 'email',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'EmailAddress',

                    ),
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'password',
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 6,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name' => 're_password', // add second password field
                'validators' => array(
                    array(
                        'name' => 'Identical',
                        'options' => array(
                            'token' => 'password', // name of first password field
                        ),
                    ),
                ),
            )));
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}