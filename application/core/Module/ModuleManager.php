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
    private $folder;
    private $module             = array();
    private $modulePathsCache        = array();

    public function __construct($config, Application $app)
    {
       parent::__construct($config, $app);
       $this->folder = IsSet($this->config['folder']) ? $this->config['folder'] : realpath(__DIR__.'/../../modules');
      //
       if(IsSet($this->config['modules']) && is_array($this->config['modules']))
       {
           foreach($this->config['modules'] as $moduleName)
           {
               $this->load($moduleName);
           }
       }
    }

    /**
     * Загружает модуль
     *
     * @param bool $name
     */
    public function load($name)
    {
        if(IsSet($this->module[$name]) || !ctype_alpha($name) || !file_exists($this->folder.'/'.$name.'/Module.php'))
            return false;

        //Подключение файла модуля
        include $this->folder.'/'.$name.'/Module.php';
        $class = '\\'.$name.'\\Module';
        if(class_exists($class))
        {
            $this->module[$name]        = new $class($this->app());

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
        return $this->folder;
    }

    public function pathForModule($name)
    {
        if(isset($this->modulePathsCache[$name]))
            return $this->modulePathsCache[$name];

        if(ctype_alpha($name) && file_exists($this->folder.'/'.$name.'/Module.php'))
        {
            return ($this->modulePathsCache[$name] = $this->folder.'/'.$name);
        }

        return ($this->modulePathsCache[$name] = false);
    }
}