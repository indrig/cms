<?php
use Engine\SetupInterface,
    Zend\ServiceManager\ServiceLocatorInterface;


class MainSetup implements SetupInterface
{

    /**
     * @return array
     */
    public function getInfo()
    {
        return array(
            'name' => 'Main'
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

return new MainSetup();
