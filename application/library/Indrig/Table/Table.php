<?php
namespace Indrig\Table;
use Indrig\Table\Element\AbstractElement,
    Indrig\Table\Element\Header;
class Table extends AbstractElement
{
    protected $headers = array();
    protected $id;
    protected static $auto_id = 0;
    /**
     * @param null|string $name
     * @param null|Header|array $headerOrElement
     * @return $this
     */
    public function addHeader($name = null, $headerOrElement = null)
    {
        if(is_array($headerOrElement))
        {
            $header = new Header($name, $headerOrElement);
            $this->headers[$name] = $header;
            return $this;
        }

        if($headerOrElement instanceof Header)
        {
            $this->headers[$name] = $headerOrElement;
            return $this;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }


    public function setId($id)
    {
        $this->id = $id;
        return $id;
    }

    public function getId()
    {
        if(!$this->id)
        {
            $this->id = 'dataTable'.++self::$auto_id;
        }
        return $this->id;
    }

    public function setOptions($options)
    {
        if(isset($options['id']))
        {
            $this->setId($options['id']);
            unset($options['id']);
        }

        parent::setOptions($options);
    }
}