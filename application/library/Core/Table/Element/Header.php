<?php
/**
 * User: Igor Bubnevich aka Core
 * Date: 21.08.13
 * Time: 12:16
 */
namespace Core\Table\Element;

class Header extends AbstractElement
{
    /**
     * @var string
     */
    protected $label;
    protected $sortable = false;

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
        if(isset($options['label']))
        {
            $this->setLabel($options['label']);
            unset($options['label']);
        }

        if(isset($options['sortable']))
        {
            $this->setSortable($options['sortable']);
            unset($options['sortable']);
        }

        parent::setOptions($options);
    }

    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    public function setSortable($sortable)
    {
        $this->sortable = $sortable;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSortable()
    {
        return $this->sortable;
    }
}