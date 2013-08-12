<?php
namespace Core\Web\Form\Element;

use Core\Web\Form\View;

class Text extends Input
{
    public function render()
    {
        $view = new View\Text();
        return $view->render($this);
    }
}