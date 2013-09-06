<?php
namespace User\Adapter;

use Zend\Authentication\Adapter\AbstractAdapter,
    Zend\Authentication\Result,
    Zend\Authentication\AuthenticationService,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\Authentication\Exception;

class Authentication extends AbstractAdapter
{
    /**
     * @var \Zend\Authentication\AuthenticationService
     */
    protected $service = null;

    /**
     * @var \User\Permissions\Acl
     */
    protected $acl = null;

    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager = null;

    /**
     * @var \User\Model\Entity\User
     */
    protected $user         = null;


   // protected $identity     = null;


    public function __construct(ServiceLocatorInterface $sm)
    {
        $this->serviceManager = $sm;
    }

    /**
     * Авторизация по залданным параметрам
     * @return Result
     */
    public function authenticate()
    {
        /**
         * @var \User\Model\UserTable $userTable
         */
        $userTable    = $this->serviceManager->get('table_user');
        $user = $userTable->getByEmail($this->getIdentity());

        if($user && $user->verifyPassword($this->getCredential()))
        {
            return new Result(Result::SUCCESS, $user->id);
        }

        $this->identity = null;
        return new Result(Result::FAILURE, null);
    }

    /**
     * Получает роль ползователя
     *
     * @return string
     */
    public function getRole()
    {

        return $this->identity !== null ? 'user_'.$this->identity : 'Guest';
    }

    /**
     * @param ServiceLocatorInterface $sm
     * @return $this
     */
    public function initialize()
    {
        //Получение необходимых сервисов
        $this->service  = $this->serviceManager->get('AuthenticationService');
        $this->acl      = $this->serviceManager->get('Acl');

        /**
         * @var \User\Model\UserTable $userTable
         */
        $userTable    = $this->serviceManager->get('table_user');

        if(($identity = $this->service->getIdentity()) !== null)
        {
            /**
             * @var \User\Model\Entity\User $user
             */
            if(($user = $userTable->getByID($identity)) !== false)
            {
                $this->user     = $user;
                $this->setIdentity($user->id);

                //Загрузкеа списка ролей для юзека
                ///////////////////////////////////////////////////////////////
                /**
                 * @var \User\Model\UserRoleTable $userRoleTable
                 */
                $userRoleTable  = $this->serviceManager->get('table_user_role');
                $roles          = $userRoleTable->getForUserId($user->id);

                /**
                 * @var \User\Permissions\Acl $Acl
                 */
                $Acl = $this->serviceManager->get('Acl');

                if(($role = $this->getRole()) !== false)
                    $Acl->addRole($role, $Acl->rolesFotUser($roles));


            }
            else
            {
                $this->service->clearIdentity();
            }
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isLogin()
    {
        return $this->identity !== null;
    }

    /**
     *
     *
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Zend\Authentication\Exception\RuntimeException
     */
    public function __call($name, $arguments)
    {
        if($this->user === null)
            throw new Exception\RuntimeException('User not authorize');

        if(method_exists($this->user, $name))
        {
            return call_user_func_array(array($this->user, $name), $arguments);
        }

        throw new Exception\RuntimeException('Call unknown function');
    }

    /**
     * Проверяет иметли пользователь права на ресурс или ресурс и действие
     *
     * @param null $resource
     * @param null $privilege
     * @return bool
     */
    public function isAllowed($resource = null, $privilege = null)
    {

        try
        {
            return $this->acl->isAllowed('Admin', $resource , $privilege);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    /**
     * @param $role
     */
    public function hasRole($role)
    {
        return $this->acl->hasRoleUser($this->getRole(), $role);
    }
}