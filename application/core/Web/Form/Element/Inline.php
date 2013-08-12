<?php
namespace Core\Web\Form\Element;

use Core\Web\Form\AbstractElement,
    Core\Web\Form\View;

class Inline extends AbstractElement
{
    protected $elements;

    public function addElement(AbstractElement $element)
    {
        $this->elements[] = $element;
    }

    public function getElements()
    {
        return $this->elements;
    }

    public function getView()
    {
        if($this->view === null)
        {

            $this->view = View\Inline::instance();
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