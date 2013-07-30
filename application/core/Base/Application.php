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

    protected $_module             = array();
    protected $_moduleConfig       = array();

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
        $this->registerCoreComponents();
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
        if($code & error_reporting())
        {

        }
    }

    protected function processRequest()
    {

    }

    protected function registerCoreComponents()
    {
        //База данных
        $this->setPlugin('db', array('class' => '\Core\Db\DataBase'));
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


        if(IsSet($this->_plugin['plugins'][$id]))
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
            $config = $this->_pluginsConfig[$id];
            if(!isset($config['enabled']) || $config['enabled'] === true)
            {
                unset($config['enabled']);

                $class_name = $this->_pluginConfig[$id]['class'];
                if(class_exists($class_name, true))
                {
                    $this->_plugin[$id] = new $class_name($this->_pluginConfig[$id]);
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
}