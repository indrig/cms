<?php
use Indrig\SetupInterface;


class UserSetup implements SetupInterface
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


return new UserSetup();