<?php
use Indrig\SetupInterface,
    Zend\ServiceManager\ServiceLocatorInterface;



class SiteMapSetup implements SetupInterface
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
     * @return array
     */
    public static function getPrivileges()
    {
        return array('read');
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

return new SiteMapSetup();