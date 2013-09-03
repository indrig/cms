<?php
namespace Core;

use Zend\ServiceManager\ServiceLocatorInterface;

interface SetupInterface
{
    /**
     * @return array
     */
    public function getInfo();

    /**
     * @return bool
     */
    public function install(ServiceLocatorInterface $sm);

    /**
     * @return bool
     */
    public function unInstall(ServiceLocatorInterface $sm);
}