<?php
namespace Core\Web\Form\Element;

use Core\Web\Form\AbstractElement,
    Core\Web\Form\View;

class Checkbox extends AbstractElement
{
    protected $attributes = array(
        'type'  => 'checkbox'
    );
    public function getView()
    {
        if($this->view === null)
        {
            $this->view = View\Checkbox::instance();
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