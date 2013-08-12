<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 12.08.13
 * Time: 13:12
 */
namespace Core\Web\Form\View;

use Exception;

class Checkbox extends AbstractView
{
    /**
     * @param \Core\Web\Form\Element\Checkbox $element
     * @return string
     */
    public function render(\Core\Web\Form\Element\Checkbox $element)
    {
        /**
         * @var Label $label
         */
        $label = Label::instance();
        $checkbox = sprintf('<input %s /> %s', $this->createAttributesString($element->getAttributes()), $element->getLabel());
        $content = '<div class="checkbox">';
        $content .= $label->render(array(), $checkbox);
        $content .= '</div>';

        return $content;
    }

    /**
     * @param \Core\Web\Form\Element\Checkbox $element
     *
     */
    public function renderRow(\Core\Web\Form\Element\Checkbox $element)
    {
        $row = '<div class="form-group">';
        $row .= '<div class="col-offset-3 col-lg-9">';
        $row .= $this->render($element);
        $row .= '</div>';
        $row .= '</div>';

        return $row;
    }
}