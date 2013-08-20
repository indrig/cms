<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 20.08.13
 * Time: 14:56
 */
namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper,
    Zend\Authentication\AuthenticationService,
    Zend\View\Exception;

class NavBar extends AbstractHelper
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
     * @return NavBar
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

        $adapter = $this->authenticationService->getAdapter();

        return '<div id="navbar-admin"><div class="container">
<ul class="nav nav-pills">
    <li class="active"><a href="#">Home</a></li>
    <li><a href="#">Help</a></li>
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Dropdown <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" role="menu">
        <li><a href="#">Action</a></li>
        <li><a href="#">Another action</a></li>
        <li><a href="#">Something else here</a></li>
        <li class="divider"></li>
        <li><a href="#">Separated link</a></li>
      </ul>
    </li>
  </ul></div></div>';
        //return $this->getServiceLocator()->->get('Zend\Authentication\AuthenticationService')->getAdapter();
    }
}