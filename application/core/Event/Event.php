<?php
namespace Core\Event;

class Event
{
    private $_sender;
    private $_params;
    public function __construct($sender = null, $params = null)
    {
        $this->_sender = $sender;
        $this->_params = $params;
    }

    public function getParams()
    {
        return $this->_params;
    }

    public function getSender()
    {
        return $this->_sender;
    }
}