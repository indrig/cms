<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 02.08.13
 * Time: 10:03
 */

/**
 * Class UserTable
 */
namespace Main\Model;

use Core\Db\TableGateway\AbstractTableGateway,
    Core\Db\Adapter,

    Main\Model\Entity\User;

class UserTable extends AbstractTableGateway
{
    protected $table = 'user';

    public function __construct(Adapter $adapter)
    {

        $this->adapter 	= $adapter;

        //$this->resultSetPrototype = new User();
    }

    public function test()
    {
        $res = $this->select();
    var_dump($res->current());
    }

    public function getByLogin($login)
    {
        $res = $this->select(array('login' => $login));
        $res->setArrayObjectPrototype(new User());
        if(($arUser = $res->current()) !== false)
        {
            return $arUser;

        }
        return false;
    }
}