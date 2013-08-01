<?php
namespace Core\Event;

class EventHandler
{
    private $_handler;
    private $_priority;
    public function __construct($handler, $priority = 0)
    {
        $this->_handler     = $handler;
        $this->_priority    = $priority;
    }

    /**
     * Вызов события на исполнение
     */
    public function call(Event $event)
    {

    }
}