<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 10:52
 */
namespace Core\Base;

abstract class Application
{
    protected $_plugin          = array();  //Миссив компонентов
    protected $_pluginConfig    = array();  //Массив настроик компонента

    protected $_config             = array();

    public function __construct($config)
    {
        //Установка приложения
        \Core\Application::setApplication($this);

        //Установка перехвата ошибок
        if(defined('CMS_ENABLE_EXCEPTION_HANDLER') && CMS_ENABLE_EXCEPTION_HANDLER === true)
            set_exception_handler(array($this,'handleException'));
        if(defined('CMS_ENABLE_ERROR_HANDLER') && CMS_ENABLE_ERROR_HANDLER === true)
            set_error_handler(array($this,'handleError'));

        register_shutdown_function(array($this, 'handleShutdown'));
        //Загрузка конфигурации
        if(is_array($config))
        {
            $this->_config = $config;
        }
        elseif(is_string($config) && file_exists($config))
        {
            $this->_config = include $config;
            if(!is_array($this->_config))
            {
                $this->_config = array();
            }
        }

        //Регистрация нужных компонентов
        $this->registerCorePlugins();

        //Включаем менаджер модулей
        $this->getModuleManager();
        //Получение настроик
    }

    /**
     * Уничтожение класса
     */
    public function __destruct()
    {

    }
    /**
     * Запуск приложения
     */
    public function run()
    {
        $this->processRequest();
    }

    /**
     * Обработчик исключений
     *
     * @param $exception
     */
    public function handleException($exception)
    {

    }

    /**
     * Обрабочик ошибок
     *
     * @param $code
     * @param $message
     * @param $file
     * @param $line
     */
    public function handleError($code, $message, $file, $line)
    {

    }

    public function handleShutdown()
    {

    }

    /**
     * Обработка самого проесса
     */
    protected function processRequest()
    {

    }

    /**
     *
     */
    protected function registerCorePlugins()
    {
        //База данных
        $this->setPlugin('cache', array('class' => '\Core\Cache\CacheManager'));
        $this->setPlugin('db', array('class' => '\Core\Db\DataBase'));
        $this->setPlugin('moduleManager', array('class' => '\Core\Module\ModuleManager'));
    }

    /**
     * @param $id           - Ид
     * @param $component    - Параметры компонента
     */
    public function setPlugin($id, $component)
    {
        if($component === null)
        {
            unset($this->_plugin[$id]);
            return;
        }


        if(IsSet($this->_config['plugins'][$id]))
        {
            $this->_pluginConfig[$id] = array_merge_recursive($this->_config['plugins'][$id], $component);
        }
        else
        {
            $this->_pluginConfig[$id] = $component;
        }

    }

    /**
     * Получение компонента
     *
     * @param $id
     * @param bool $createIfNull
     * @return null
     */
    public function getPlugin($id, $createIfNull=true)
    {
        if(isset($this->_plugin[$id]))
        {
            return $this->_plugin[$id];
        }
        elseif(isset($this->_pluginConfig[$id]) && $createIfNull)
        {
            $config = $this->_pluginConfig[$id];
            if(!isset($config['enabled']) || $config['enabled'] === true)
            {
                unset($config['enabled']);

                $class_name = $this->_pluginConfig[$id]['class'];
                if(class_exists($class_name, true))
                {
                    $this->_plugin[$id] = new $class_name($this->_pluginConfig[$id], $this);
                    return $this->_plugin[$id];
                }
            }
        }

        return null;
    }

    /**
     *
     */
    public function __get($name)
    {
        return $this->getPlugin($name);
    }

    /**
     *
     * @return \Core\Module\ModuleManager
     */
    public function getModuleManager()
    {

        return $this->getPlugin('moduleManager');
    }

    /**
     *
     * @return \Core\Db\DataBase
     */
    public function getDB()
    {
        return $this->getPlugin('db');
    }

    /**
     *
     * @return \Core\Cache\Cache
     */
    public function getCache()
    {
        return $this->getPlugin('cache');
    }

    public function finish()
    {
        exit;
    }
}