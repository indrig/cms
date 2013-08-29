<?php
namespace Indrig;

use Zend\ServiceManager\ServiceLocatorInterface;

interface SetupInterface
{
    /**
     * @return array
     */
    public static function getInfo();

    /**
     * @return bool
     */
    public static function install(ServiceLocatorInterface $sm);

    /**
     * @return bool
     */
    public static function unInstall(ServiceLocatorInterface $sm);
}