<?php
namespace Indrig;

interface SetupInterface
{
    /**
     * @return array
     */
    public static function getInfo();

   /**
    * @return array
    */
    public static function getPrivileges();

    /**
     * @return bool
     */
    public static function install();

    /**
     * @return bool
     */
    public static function unInstall();
}