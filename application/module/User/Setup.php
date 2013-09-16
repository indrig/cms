<?php
use Engine\SetupInterface,
    Zend\ServiceManager\ServiceLocatorInterface;


class UserSetup implements SetupInterface
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


return new UserSetup();