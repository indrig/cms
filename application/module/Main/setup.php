<?php
use Indrig\SetupInterface,
    Zend\ServiceManager\ServiceLocatorInterface;


class MainSetup implements SetupInterface
{

    /**
     * @return array
     */
    public static function getInfo()
    {
        return array(
            'name' => 'Main'
        );
    }


    /**
     * @return bool
     */
    public static function install(ServiceLocatorInterface $sm)
    {
        return false;
    }

    /**
     * @return bool
     */
    public static function unInstall(ServiceLocatorInterface $sm)
    {
        return false;
    }
}

return new MainSetup();
