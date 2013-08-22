<?php
namespace Indrig\Table;

use Indrig\Table\Element\AbstractElement,
    Indrig\Table\Element\Header,
    Indrig\Table\Adapter\AdapterInterface;

class Table extends AbstractElement
{
    protected $headers = array();
    protected $id;
    protected static $auto_id = 0;
    /**
     * @var \Indrig\Table\Adapter\AdapterInterface
     */
    protected $adapter  = null;
    protected $data     = array();
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

    /**
     * @param AdapterInterface $adapter
     * @return $this
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }

    /**
     * @return AdapterInterface|null
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    public function getData()
    {
        if($this->data)
            return $this->data;

        return ($this->data = $this->getAdapter()->getData());
    }

}