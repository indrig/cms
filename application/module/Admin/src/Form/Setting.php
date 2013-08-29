<?php
namespace Admin\Form;

use Zend\Form\Form,
    Zend\Form\FormInterface;

class Setting extends Form
{
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
            'name' => 'headTitle',
            'options' => array(
                'label' => 'Head title',
            ),
            'attributes' => array(
                'type'  => 'text',
            ),
        ));


    }
}