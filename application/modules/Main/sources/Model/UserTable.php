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

use Core\Db\TableGateway\AbstractTableGateway;
use Core\Db\Adapter,

    Core\Db\Sql\Sql;

class UserTable extends AbstractTableGateway
{
    protected $table = 'user';

    public function __construct(Adapter $adapter)
    {
        $this->adapter 	= $adapter;
    }

    public function test()
    {
        $res = $this->select();
    var_dump($res->current());
    }
}