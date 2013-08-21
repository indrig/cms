<?php
namespace Indrig\Table;
use Indrig\Table\Element\AbstractElement,
    Indrig\Table\Element\Header;
class Table extends AbstractElement
{
    protected $headers = array();

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


}