<?php
namespace Core\Web\Form\View;

use Exception;

class Input extends AbstractView
{
    protected $type;

    /**
     * @param \Core\Web\Form\AbstractElement $element
     * @return string
     * @throws \Exception
     */
    public function render($element)
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
        $attributes['class'] = 'form-control'.(isset($attributes['class']) ? $attributes['class'] : '');

        return sprintf(
            '<input %s />',
            $this->createAttributesString($attributes)
        );
    }
}