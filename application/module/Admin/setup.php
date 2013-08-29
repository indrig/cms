<?php
use Indrig\SetupInterface,
    Zend\ServiceManager\ServiceLocatorInterface;


class AdminSetup implements SetupInterface
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
        return array('management', 'setting');
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

return new AdminSetup();
