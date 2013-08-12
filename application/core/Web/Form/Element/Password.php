<?php
namespace Core\Web\Form\Element;

use Core\Web\Form\View;

class Password extends Input
{
    public function render()
    {
        $view = new View\Password();
        return $view->render($this);
    }
}