<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 20.08.13
 * Time: 14:54
 */
namespace Admin\View\Helper\Service;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Admin\View\Helper\NavBar;

class NavBarFactory implements FactoryInterface
{
    /**
     * @return \User\View\Helper\User
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();
        $helper = new NavBar();
        if ($services->has('Zend\Authentication\AuthenticationService'))
        {
            $helper->setAuthenticationService($services->get('Zend\Authentication\AuthenticationService'));
        }
        return $helper;
    }
}
