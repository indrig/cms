<?php
namespace Core\Web\Form\View;

use Exception;

class Button extends AbstractView
{
    public function render(\Core\Web\Form\Element\Button $element)
    {
        $element->addClass('btn btn-'.$element->getButtonStyle());
        return sprintf('<button %s>%s</button>', $this->createAttributesString($element->getAttributes()), $element->getLabel());
    }

    public function renderRow(\Core\Web\Form\Element\Button $element)
    {
        $element->addClass('form-control');
        $row = '<div class="form-group">';
        $row .= '<div class="col-lg-9">';
        $row .= $this->render($element);
        $row .= '</div>';
        $row .= '</div>';

        return $row;
    }
}