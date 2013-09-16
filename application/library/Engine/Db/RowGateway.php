<?php
/**
 * User: Igor Bubnevich aka Core
 * Date: 26.08.13
 * Time: 10:50
 */

namespace Engine\Db;

use Zend\Db\Adapter\Adapter,
    Zend\Db\Sql\Sql,
    Zend\Db\RowGateway\AbstractRowGateway,
    Zend\Db\RowGateway\Exception;

class RowGateway extends AbstractRowGateway
{
    /**
     * Constructor
     *
     * @param string $primaryKeyColumn
     * @param string|\Zend\Db\Sql\TableIdentifier $table
     * @param Adapter|Sql $adapterOrSql
     * @throws Exception\InvalidArgumentException
     */
    public function __construct($primaryKeyColumn, $table, $adapterOrSql = null)
    {
        // setup primary key
        $this->primaryKeyColumn = (array) $primaryKeyColumn;

        // set table
        $this->table = $table;

        // set Sql object
        if ($adapterOrSql instanceof Sql) {
            $this->sql = $adapterOrSql;
        } elseif ($adapterOrSql instanceof Adapter) {
            $this->sql = new Sql($adapterOrSql, $this->table);
        } else {
            throw new Exception\InvalidArgumentException('A valid Sql object was not provided.');
        }

        if ($this->sql->getTable() !== $this->table) {
            throw new Exception\InvalidArgumentException('The Sql object provided does not have a table that matches this row object');
        }

        $this->initialize();
    }
}