<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 14.08.13
 * Time: 13:07
 */
namespace User\Adapter;

use Zend\Authentication\Adapter\AbstractAdapter,
    Zend\Authentication\Result,
    Zend\Authentication\AuthenticationService;

class Authentication extends  AbstractAdapter
{
    /**
     * @var \Zend\Authentication\AuthenticationService
     */
    protected $service = null;
    /**
     * @var \User\Model\Entity\User
     */
    protected $user         = null;
    /**
     * @var \User\Model\UserTable $userTable
     */
    protected $userTable    = null;

    protected $identity     = null;

    public function __construct($userTable)
    {
        $this->userTable = $userTable;
    }

    public function authenticate()
    {
        $user = $this->userTable->getByLogin($this->getIdentity());
        if($user && $user->verifyPassword($this->getCredential()))
        {
            return new Result(Result::SUCCESS, $user->id);
        }

        return new Result(Result::FAILURE, null);
    }


    public function getRole()
    {
        return $this->user && $this->user->role ? $this->user->role : false;
    }

    public function initialize(AuthenticationService $service)
    {
        $this->service = $service;
        if(($identity = $service->getIdentity()) !== null)
        {
            if(($user = $this->userTable->getByID($identity)) !== false)
            {
                $this->user     = $user;
                $this->identity = $user->id;
            }
            else
            {
                $service->clearIdentity();
            }
        }
    }

    public function isLogin()
    {

        return $this->identity !== null;
    }
}