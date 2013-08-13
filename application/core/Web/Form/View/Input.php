<?php
namespace Core\Web\Form\View;

use Exception;

class Input extends AbstractView
{
    protected $type;

    public function render(\Core\Web\Form\Element\Input $element)
    {
        $name = $element->getName();
        if ($name === null || $name === '') {
            throw new Exception(sprintf(
                '%s requires that the element has an assigned name; none discovered',
                __METHOD__
            ));
        }

        $attributes          = $element->getAttributes();
        $attributes['name']  = $name;
        $attributes['type']  = $this->type;
        $attributes['value'] = $element->getValue();
        $element->addClass('form-control');
        return sprintf(
            '<input %s />',
            $this->createAttributesString($attributes)
        );
    }

    public function renderRow(\Core\Web\Form\Element\Input $element)
    {
        $element->addClass('form-control');
        $row = '<div class="form-group">';
        if(!$element->hasAttribute('id'))
        {
            $element->setAttribute('id', 'input_'.$element->getName());
        }
        /**
        * @var Label $label
        */
        $label = Label::instance();
        $row .= $label->render(
            array(
                'class' => 'col-lg-3 control-label',
                'for'   => $element->getAttribute('id')
            ),
            $element->getLabel()
        );
        $row .= '<div class="col-lg-3">';
        $row .= $this->render($element);
        $row .= '</div>';
        $row .= '</div>';

        return $row;
    }
}