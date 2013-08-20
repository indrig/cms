<?php
namespace User\View\Helper\Service;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    User\View\Helper\User;

class UserFactory implements FactoryInterface
{
    /**
     * @return \User\View\Helper\User
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();
        $helper = new User();
        if ($services->has('AuthenticationService'))
        {
            $helper->setAuthenticationService($services->get('AuthenticationService'));
        }
        return $helper;
    }
}
