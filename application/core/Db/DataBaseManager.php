<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 13:32
 */

namespace Core\Db;

use Core\Base\Plugin,
    Core\Db\TableGateway\TableGatewayInterface,
    Core\Db\Adapter
    ;

class DataBaseManager extends Plugin
{

    private $tables    = array();
    private $adapters  = array();

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
        $this->tables[$name] = array(
            'adapter'   => $adapter instanceof DataBaseManager ? $adapter : 'default',
            'class'     => $class,
            'instance'  => null
        );
    }

    public function table($name)
    {
        if(!isset($this->tables[$name]))
            return null;

        $table = &$this->tables[$name];

        if($table['instance'] instanceof TableGatewayInterface)
            return $this->tables[$name]['instance'];

        return ($table['instance'] = new $table['class']($table['adapter'] instanceof Adapter?:$this->adapter($table['adapter'])));
    }

    /**
     * @param $name
     */
    public function adapter($name)
    {
        if(IsSet($this->adapters[$name]))
           return $this->adapters[$name];

        if(IsSet($this->config['adapters'][$name]))
        {
            return ($this->adapters[$name] = new Adapter($this->config['adapters'][$name]));
        }

        return $this;
    }
}