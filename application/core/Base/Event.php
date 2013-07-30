<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 12:15
 */
namespace Core\Base;

class Event
{
    public $sender;
    public $handled=false;
    public $params;

    public function __construct($sender=null,$params=null)
    {
        $this->sender = $sender;
        $this->params = $params;
    }
}