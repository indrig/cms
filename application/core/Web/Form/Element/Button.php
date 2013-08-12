<?php
namespace Core\Web\Form\Element;

use Core\Web\Form\AbstractElement,
    Core\Web\Form\View;

class Button extends AbstractElement
{
    protected $attributes = array('type' => 'button');
    protected $allowButtonStyles = array(
        'default',
        'primary',
        'success',
        'info',
        'warning',
        'danger',
        'link'
    );

    protected $style = 'default';

    public function __construct($name = null, $options = array(), $parent = null)
    {
        if(isset($options['buttonstyle']))
        {
            $this->setButtonStyle($options['buttonstyle']);
            unset($options['buttonstyle']);
        }
        parent::__construct($name, $options, $parent);
    }

    public function getView()
    {
        if($this->view === null)
        {

            $this->view = View\Button::instance();
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

    public function setButtonStyle($style)
    {
        $this->style = $style;
    }

    public function getButtonStyle()
    {
        return $this->style;
    }
}