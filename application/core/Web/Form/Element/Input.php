<?php
namespace Core\Web\Form\Element;

use Core\Web\Form\AbstractElement,
    Core\Web\Form\View;

abstract class Input extends AbstractElement
{
    public function getView()
    {
        if($this->view === null)
        {
            $class = str_replace('Element', 'View', get_called_class());
            $this->view = call_user_func(array($class, 'instance'));
        }
        return $this->view;
    }

    public function render()
    {
        $view = $this->getView();
        return $view->render($this);
    }

    public function renderRow()
    {
        $view = $this->getView();
        return $view->renderRow($this);
    }
}