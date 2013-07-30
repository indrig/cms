<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Indrig
 * Date: 30.07.13
 * Time: 23:12
 * To change this template use File | Settings | File Templates.
 */
namespace Core\Module;


use Core\Base\Plugin,
    Core\Base\Application;

class ModuleManager extends Plugin
{
    private $_folder;
    private $_module = array();


    public function __construct($config, Application $app)
    {
       parent::__construct($config, $app);
       $this->_folder = IsSet($this->_config['folder']) ? $this->_config['folder'] : realpath(__DIR__.'/../../modules');
    }

    /**
     * Загружает модуль
     *
     * @param bool $name
     */
    public function load($name)
    {
        if(IsSet($this->_module[$name]) || !ctype_alpha($name) || !file_exists($this->_folder.'/'.$name.'/Module.php'))
            return false;

        //Подключение файла модуля
        include $this->_folder.'/'.$name.'/Module.php';
        $class = '\\'.$name.'\\Module';
        if(class_exists($class))
        {
            $this->_module[$name] = new $class($this->app());
        }
        return true;
    }

    /**
     * Возвращает путь к катологу с модулями
     *
     * @return string
     */
    public function getFolder()
    {
        return $this->_folder;
    }
}