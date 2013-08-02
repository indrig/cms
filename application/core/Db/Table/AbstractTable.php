<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 02.08.13
 * Time: 10:04
 */
namespace Core\Db\Table;

use Core\Db\Adapter,
    Core\Db\Sql\Select,
    Core\Db\Sql\Sql;

abstract class AbstractTable
{
    protected $_adapter;
    protected $_table;
    protected $_sql;

    public function __construct(Adapter $adapter)
    {
        $this->_adapter = $adapter;
        $this->_sql = new Sql($this->_adapter, $this->_table);
    }

    public function setTable($table)
    {
        $this->_table = $table;
    }

    public function getTable()
    {
        return $this->_table;
    }

    public function select()
    {
        $select = $this->_sql->select();
    }


}