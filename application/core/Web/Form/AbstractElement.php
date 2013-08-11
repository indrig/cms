<?php
namespace Core\Web\Form;

abstract class AbstractElement
{
    protected $name;
    protected $options;
    protected $parent;
    protected $value;
    protected $label;
    protected $attributes = array();

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

    /**
     * @return string Имя элемента
     */
    public function getName()
    {
        return $this->name;
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

    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the element value
     *
     * @param  mixed $value
     * @return AbstractElement
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Retrieve the element value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the label used for this element
     *
     * @param $label
     * @return AbstractElement
     */
    public function setLabel($label)
    {
        if (is_string($label)) {
            $this->label = $label;
        }

        return $this;
    }

    /**
     * Retrieve the label used for this element
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
}