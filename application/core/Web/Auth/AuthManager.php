<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 01.08.13
 * Time: 16:55
 */
namespace Core\Web\Auth;

use Exception,
    Core\Base\Plugin,
    Core\Web\Auth\AdapterInterface;

class AuthManager extends Plugin
{
    private $authorized    = false;
    private $user;
    private $adapter;

    public function setupAuth(AdapterInterface $adapter)
    {
        if($this->adapter instanceof AdapterInterface)
        {
           throw new Exception('Auth adapter already setup');
        }
        $this->adapter = $adapter;
    }

    public function isAuthorized()
    {
        //return $this->_authorized;
    }

    public function start()
    {
        if($this->adapter instanceof AdapterInterface)
        {
            return;
        }
    }
}