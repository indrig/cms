<?php
namespace User\View\Helper;

use Zend\View\Helper\AbstractHelper,
     Zend\Authentication\AuthenticationService,
    Zend\View\Exception;

class User extends AbstractHelper
{
    protected $serviceLocator;

    /**
     * AuthenticationService instance
     *
     * @var AuthenticationService
     */
    protected $authenticationService;

    /**
     * Set AuthenticationService instance
     *
     * @param AuthenticationService $authenticationService
     * @return User
     */
    public function setAuthenticationService(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
        return $this;
    }

    /**
     * Get AuthenticationService instance
     *
     * @return AuthenticationService
     */
    public function getAuthenticationService()
    {
        return $this->authenticationService;
    }

    public function __invoke()
    {
        if (!$this->authenticationService instanceof AuthenticationService) {
            throw new Exception\RuntimeException('No AuthenticationService instance provided');
        }

        return $this->authenticationService->getAdapter();
        //return $this->getServiceLocator()->->get('Zend\Authentication\AuthenticationService')->getAdapter();
    }
}