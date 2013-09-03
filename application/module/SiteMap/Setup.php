<?php
use Core\SetupInterface,
    Zend\ServiceManager\ServiceLocatorInterface;



class SiteMapSetup implements SetupInterface
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
        return array('read');
    }

    /**
     * @return bool
     */
    public function install(ServiceLocatorInterface $sm)
    {
        return true;
    }

    /**
     * @return bool
     */
    public function unInstall(ServiceLocatorInterface $sm)
    {
        return true;
    }
}

return new SiteMapSetup();