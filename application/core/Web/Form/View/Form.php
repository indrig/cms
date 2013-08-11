<?php
namespace Core\Web\Form\View;

use Core\Web\Form\AbstractElement;

class Form extends AbstractView
{
    /**
     * @param \Core\Web\Form\Form $form
     * @return string
     */
    public function render($form)
    {
        $form_content = '';
        $elements = $form->getElements();
        /**
         * @var AbstractElement $element;
         */
        foreach($elements as $element)
        {
            if($form->getOrientation() === \Core\Web\Form\Form::ORIENTATION_VERTICAL)
            {
                $form_content .= '<div class="form-group">'.$element->render().'</div>';
            }
        }
        return $this->openTag($form).$form_content.$this->closeTag();
    }

    public function openTag($form)
    {
        $attributes = array(
            'action' => '',
            'method' => 'get',
        );

        $tag = sprintf('<form %s>', $this->createAttributesString($attributes));

        return $tag;
    }

    public function closeTag()
    {
        return '</form>';
    }
}