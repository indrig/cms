<?php
namespace User\Form;

use Zend\Form\Form,
    Zend\Form\FormInterface,
    Zend\InputFilter\Factory,
    Zend\InputFilter\InputFilter;

class Role extends Form
{
    private $inputFilter;
    public function __construct()
    {
        parent::__construct(null, array(

        ));

        $this->setWrapElements(true);
        $this->prepare();
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
                'class' => 'form-control',
                'id'    => 'inputLogin'
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
                            'max'      => 64,
                        ),
                    ),
                ),
            )));
            //Логин
            $inputFilter->add($factory->createInput(array(
                'name'     => 'password',
                'required' => true,
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
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}