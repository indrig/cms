<?php
use Indrig\SetupInterface,
    Zend\ServiceManager\ServiceLocatorInterface;;



class NewsSetup implements SetupInterface
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

    public function installHtmlOptions(ServiceLocatorInterface $sm)
    {
        return 'test';
    }
}

return new NewsSetup();