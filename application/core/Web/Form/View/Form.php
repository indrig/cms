<?php
namespace Core\Web\Form\View;

use Core\Web\Form\AbstractElement;

class Form extends AbstractView
{

    /**
     * @return string
     */
    public function render(\Core\Web\Form\Form $form)
    {
        $form_content = '';

        $elements = $form->getElements();
        /**
         * @var AbstractElement $element;
         */

        if($form->getOrientation() === \Core\Web\Form\Form::ORIENTATION_VERTICAL)
        {
            $form->addClass('form-horizontal');
        }
        else
        {
            $form->addClass('form-inline');
        }
        foreach($elements as $element)
        {
            if($form->getOrientation() === \Core\Web\Form\Form::ORIENTATION_VERTICAL)
            {
                $form_content .= $element->renderRow();
            }
            else
            {
                $form_content .= $element->render();
            }
        }
        return $this->openTag($form).$form_content.$this->closeTag();
    }

    public function openTag(\Core\Web\Form\Form $form)
    {
        $attributes = array(
            'action' => '',
            'method' => 'get',
        );

        $formAttributes = $form->getAttributes();
        if (!array_key_exists('id', $formAttributes) && array_key_exists('name', $formAttributes)) {
            $formAttributes['id'] = $formAttributes['name'];
        }
        $attributes = array_merge($attributes, $formAttributes);

        return sprintf('<form %s>', $this->createAttributesString($attributes));
    }

    public function closeTag()
    {
        return '</form>';
    }
}