<?php
error_reporting(E_ALL | E_NOTICE);
chdir(__DIR__);
include  'library/Zend/Loader/AutoloaderFactory.php';

if (!class_exists('Zend\Loader\AutoloaderFactory'))
{
     throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.');
}
define('ROUTE_ADMIN', 'admin');
Zend\Loader\AutoloaderFactory::factory(
	array(
		'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf'   => true,
                'namespaces'        => array(
                    'Engine'        => 'library/Engine'
                )
        )
    )
);

class Application
{
    /**
     * @var Zend\Mvc\Application
     */
    private static $instance;

    /**
     * @return \Zend\Mvc\Application
     */
    public static function App()
    {
        if(self::$instance)
            return self::$instance;

        self::$instance = Zend\Mvc\Application::init(require 'config/application.config.php');

        return self::$instance;
    }

}

//INIT
