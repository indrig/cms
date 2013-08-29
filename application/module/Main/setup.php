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
