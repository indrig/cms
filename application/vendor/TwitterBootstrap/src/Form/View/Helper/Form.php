<?php
namespace TwitterBootstrap\Form\View\Helper;

use Zend\Form\View\Helper\Form as ZendViewHelperForm,
    Zend\Form\FormInterface,
    TwitterBootstrap\Form\Form as TBForm;


class Form extends ZendViewHelperForm
{
    /**
     * Mapping of form types to form css classes
     * @var array
     */
    protected static $formTypeMap      = array(
        TBForm::FORM_TYPE_HORIZONTAL => 'form-horizontal',
        TBForm::FORM_TYPE_VERTICAL   => 'form-vertical',
        TBForm::FORM_TYPE_INLINE     => 'form-inline',
        TBForm::FORM_TYPE_SEARCH     => 'form-search',
    );

    /**
     * Invoke as function
     *
     * @param  null|FormInterface $form
     * @return Form
     */
    public function __invoke(FormInterface $form = null, $formType = null)
    {
        if (!$form)
        {
            return $this;
        }

        return $this->render($form, $formType);
    }
    /**
     * Render a form from the provided $form,
     *
     * @param  FormInterface $form
     * @return string
     */
    public function render(FormInterface $form, $formType = null)
    {
        if (method_exists($form, 'prepare'))
        {
            $form->prepare();
        }

        $formContent = '';

        foreach ($form as $element)
        {
            if ($element instanceof FieldsetInterface)
            {
                $formContent.= $this->getView()->TBFormCollection($element);
            }
            else
            {


                $formContent.= $this->getView()->TBFormRow($element, null, null, null, $formType);
            }
        }

        return $this->openTag($form) . $formContent . $this->closeTag();
    }

    /**
     * @param FormInterface $form
     * @param string $formType
     * @return string
     */
    public function openTag(FormInterface $form = null, $formType = null)
    {
        $formTypeClass = isset($formTypeMap[$formType]) ? $this->formTypeMap[$formType] : 'form-horizontal';

        if ($form)
        {
            $class = $form->hasAttribute('class') ? $form->getAttribute('class').' '.$formTypeClass : $formTypeClass;
            $form->setAttribute('class', $class);

        }
        return parent::openTag($form);
    }

}