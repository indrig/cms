<?php
namespace Core\Web\Form;

abstract class AbstractElement
{
    protected $name;
    protected $options;
    protected $parent;

    public function __construct($name = null, $options = array(), $parent = null)
    {
        if (null !== $name)
        {
            $this->setName($name);
        }

        if (!empty($options))
        {
            $this->setOptions($options);
        }

        if (null !== $parent)
        {
            $this->setName($name);
        }
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        $this->name;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    public function getParent()
    {
        $this->parent;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    abstract public function render();

    public function __toString()
    {
        return $this->render();
    }
}