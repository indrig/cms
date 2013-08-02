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

use Core\Db\Table\AbstractTable,
    Core\Db\Sql\Sql;

class UserTable extends AbstractTable
{
    protected $_table = 'user';
    public function getList()
    {

    }

    public function get()
    {

    }

    public function delete()
    {

    }

    public function save()
    {

    }

    public function test()
    {
        $sql = new Sql($this->_adapter, 'user');
        $select = $sql->select();
        //$sql->ex
        var_dump($sql);
    }
}