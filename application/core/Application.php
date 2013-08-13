<?php
namespace Core;

class Application
{
    private static $instance;
    /**
     * Создает новое Web приложение
     * @param $config   - файл конфигурации
     * @return \Core\Web\Application
     */
    public static function createWebApplication($config)
    {
        return self::createApplication('\Core\Web\Application', $config);
    }

    public static function createApplication($class, $config)
    {
        if(!class_exists('A'))
            class_alias('\Core\Application', 'A');

        return new $class($config);
    }

    /**
     * @param \Core\Base\Application $app   Приложение
     */
    public static function setApplication(Base\Application $app)
    {
        if(self::$instance === null || $app === null)
        {
            self::$instance = $app;
            return false;
        }

        return false;
    }

    /**
     * @return \Core\Web\Application
     */
    public static function app()
    {
        return self::$instance;
    }
}