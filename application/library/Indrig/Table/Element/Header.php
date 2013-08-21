<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 21.08.13
 * Time: 12:16
 */
namespace Indrig\Table\Element;

class Header extends AbstractElement
{
    /**
     * @var string
     */
    protected $label;

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
}