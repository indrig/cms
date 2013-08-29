<?php
use Indrig\SetupInterface,
    Zend\ServiceManager\ServiceLocatorInterface;;



class NewsSetup implements SetupInterface
{

    /**
     * @return array
     */
    public static function getInfo()
    {
        return array(
            'name' => 'Site Map'
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

return new NewsSetup();