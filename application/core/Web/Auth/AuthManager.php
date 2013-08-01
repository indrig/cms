<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 01.08.13
 * Time: 16:55
 */
namespace Core\Web\Auth;

use Core\Base\Plugin;

class AuthManager extends Plugin
{
    private $_authorized    = false;
    private $_user          ;
    public function isAuthorized()
    {
        return $this->_authorized;
    }
}