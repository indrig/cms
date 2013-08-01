<?php
namespace Core\Event;

use Core\Base\Plugin;

class EventManager extends  Plugin
{
    private $_events        = array();
    private $_moduleEvents  = array();

    /**
     * Добавление обрабочика события
     *
     * @param $name             - Название
     * @param $handler          - Обработчик
     * @param int $priority     - Приоритет
     * @return EventHandler     -
     */
    public function addEvent($name, $handler, $priority = 0)
    {
        $name = strtolower($name);
        if(!IsSet($this->_events[$name]))
            $this->_events[$name] = array();

        return ($this->_events[$name][] = new EventHandler($handler, $priority));
    }

    /**
     * Удаляет событие по указателю
     * @param EventHandler $eventHandler
     */
    public function removeEvent($name, EventHandler $eventHandler)
    {
        $name = strtolower($name);
        if(isset($this->_events[$name]) && is_array($this->_events[$name]))
        {
            if(($key = array_search($eventHandler, $this->_events[$name], true)) !== false)
            {
                unset($this->_events[$name][$key]);
            }
        }
        return $this;
    }

    /**
     * Вызыв события
     *
     * @param $name         - название
     * @param array $param  - параметры
     */
    public function event($name, Event $event)
    {
        $name = strtolower($name);
        if(isset($this->_events[$name]) && is_array($this->_events[$name]))
        {
            /**
             * @var EventHandler $handler
             */
            foreach($this->_events[$name] as $handler)
            {
                $handler->call($event);
            }
        }
        return $this;
    }

    /**
     * Добавление обрабочика события
     * @param $module           - Модуль
     * @param $name             - Название
     * @param $handler          - Обработчик
     * @param int $priority     - Приоритет
     * @return EventHandler     - Указатель на событие
     */
    public function addModuleEvent($module, $name, $handler, $priority = 0)
    {
        $module = strtolower($module);
        $name   = strtolower($name);
        if(!IsSet($this->_moduleEvents[$module][$name]))
            $this->_moduleEvents[$module][$name] = array();

        return ($this->_moduleEvents[$module][$name][] = new EventHandler($handler, $priority));
    }

    /**
     * Удаляет событие по указателю
     * @param EventHandler $eventHandler
     */
    public function removeModuleEvent($module, $name, EventHandler $eventHandler)
    {
        $name = strtolower($name);
        $module = strtolower($module);
        if(isset($this->_moduleEvents[$module][$name]) && is_array($this->_moduleEvents[$module][$name]))
        {
            if(($key = array_search($eventHandler, $this->_moduleEvents[$module][$name], true)) !== false)
            {
                unset($this->_moduleEvents[$module][$name][$key]);
            }
        }
        return $this;
    }

    /**
     * Вызыв события
     *
     * @param $name         - название
     * @param array $param  - параметры
     */
    public function moduleEvent($module, $name, Event $event)
    {
        $name = strtolower($name);
        $module = strtolower($module);
        if(isset($this->_moduleEvents[$module][$name]) && is_array($this->_moduleEvents[$module][$name]))
        {
            /**
             * @var EventHandler $handler
             */
            foreach($this->_moduleEvents[$module][$name] as $handler)
            {
                $handler->call($event);
            }
        }
        return $this;
    }
}