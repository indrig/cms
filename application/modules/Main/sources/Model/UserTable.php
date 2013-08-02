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

use Core\Db\TableGateway,
    Core\Db\Sql\Sql;

class UserTable extends TableGateway\AbstractTableGateway
{
    protected $_table = 'user';


    public function test()
    {
        $res = $this->select();
        var_dump($res);
    }
}