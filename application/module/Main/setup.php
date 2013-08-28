<?php
use Indrig\SetupInterface;


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
     * @return array
     */
    public static function getPrivileges()
    {
        return array();
    }

    /**
     * @return bool
     */
    public static function install()
    {
        return false;
    }

    /**
     * @return bool
     */
    public static function unInstall()
    {
        return false;
    }
}

return new MainSetup();
