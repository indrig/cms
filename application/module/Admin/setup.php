<?php
use Core\SetupInterface,
    Zend\ServiceManager\ServiceLocatorInterface;


class AdminSetup implements SetupInterface
{

    /**
     * @return array
     */
    public function getInfo()
    {
        return array(
            'name' => 'Site Map'
        );
    }

    /**
     * @return array
     */
    public function getPrivileges()
    {
        return array('management', 'setting');
    }

    /**
     * @return bool
     */
    public function install(ServiceLocatorInterface $sm)
    {
        return false;
    }

    /**
     * @return bool
     */
    public function unInstall(ServiceLocatorInterface $sm)
    {
        return false;
    }
}

return new AdminSetup();
