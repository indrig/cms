<?php
use Indrig\SetupInterface;



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

return new SiteMapSetup();