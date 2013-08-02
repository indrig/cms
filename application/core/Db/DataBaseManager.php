<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 13:32
 */

namespace Core\Db;

use Core\Base\Plugin,
    Core\Db\Table\AbstractTable,
    Core\Db\Adapter
    ;

class DataBaseManager extends Plugin
{

    private $_tables    = array();
    private $_adapters  = array();

    public function __construct($config)
    {
        parent::__construct($config);
        //$driver = $this->createDriver();
       // $driver->checkEnvironment();
        //$this->_driver = $driver;
    }


    public function registerTable($name, $class, $adapter = null)
    {
        $name = strtolower($name);
        $this->_tables[$name] = array(
            'adapter'   => $adapter instanceof DataBaseManager ? $adapter : 'default',
            'class'     => $class,
            'instance'  => null
        );
    }

    public function table($name)
    {
        if(!isset($this->_tables[$name]))
            return null;

        $table = &$this->_tables[$name];

        if($table['instance'] instanceof AbstractTable)
            return $this->_tables[$name]['instance'];

        return ($table['instance'] = new $table['class']($table['adapter'] instanceof Adapter?:$this->adapter($table['adapter'])));
    }

    /**
     * @param $name
     */
    public function adapter($name)
    {
        if(IsSet($this->_adapters[$name]))
           return $this->_adapters[$name];

        if(IsSet($this->_config['adapters'][$name]))
        {
            return ($this->_adapters[$name] = new Adapter($this->_config['adapters'][$name]));
        }

        return $this;
    }
}