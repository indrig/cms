<?php
namespace Core\Web\Form\View;

use Core\Web\Form\AbstractElement;
use Exception;

class Inline extends AbstractView
{
    protected $type;

    public function render(\Core\Web\Form\Element\Inline $element)
    {

        $content = '';
        /**
         * @var AbstractElement $child
         */
        foreach($element->getElements() as $child)
        {
            $content .= (is_string($child) ? : $child->render())."\n";
        }

        return $content;
    }

    public function renderRow(\Core\Web\Form\Element\Inline $element)
    {
        $element->addClass('form-control');
        $row = '<div class="form-group">';
        $row .= '<div class="col-lg-9 col-offset-3">';
        $row .= $this->render($element);
        $row .= '</div>';
        $row .= '</div>';

        return $row;
    }
}