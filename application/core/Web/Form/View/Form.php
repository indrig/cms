<?php
namespace Core\Web\Form\View;

class Form extends AbstractView
{
    public function render($form)
    {
        $form_content = '';
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