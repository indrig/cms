<?php
/**
 * User: Igor Bubnevich aka Core
 * Date: 21.08.13
 * Time: 12:17
 */
namespace Engine\Table\Element;

class Cell extends AbstractElement
{
    protected $renderFunction = null;

    public function __construct($name, $options = null)
    {
        $this->name = $name;
        if($options !== null)
        {
            $this->setOptions($options);
        }
    }

    public function setOptions($options)
    {
        if(isset($options['render']))
        {
            $this->setRender($options['render']);
            unset($options['render']);
        }

        parent::setOptions($options);
    }

    public function setRender($render)
    {
        $this->renderFunction = $render;
        return $this;
    }

    public function getRender()
    {
        return $this->renderFunction;
    }

    /**
     * Отрисовка ячейки
     *
     * @param $row
     */
    public function render($row)
    {
        return call_user_func_array($this->renderFunction, array('row' => $row));
    }
}