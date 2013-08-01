<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 01.08.13
 * Time: 18:09
 */
namespace Core\Db\Sql;

use Exception;

class Select
{
    const SELECT                = 'select';
    const QUANTIFIER            = 'quantifier';
    const COLUMNS               = 'columns';
    const TABLE                 = 'table';
    const JOINS                 = 'joins';
    const WHERE                 = 'where';
    const GROUP                 = 'group';
    const HAVING                = 'having';
    const ORDER                 = 'order';
    const LIMIT                 = 'limit';
    const OFFSET                = 'offset';
    const QUANTIFIER_DISTINCT   = 'DISTINCT';
    const QUANTIFIER_ALL        = 'ALL';
    const JOIN_INNER            = 'inner';
    const JOIN_OUTER            = 'outer';
    const JOIN_LEFT             = 'left';
    const JOIN_RIGHT            = 'right';
    const SQL_STAR              = '*';
    const ORDER_ASCENDING       = 'ASC';
    const ORDER_DESCENDING      = 'DESC';
    const COMBINE               = 'combine';
    const COMBINE_UNION         = 'union';
    const COMBINE_EXCEPT        = 'except';
    const COMBINE_INTERSECT     = 'intersect';

    protected $_table   = null;
    protected $_limit   = null;
    protected $_offset  = null;

    public function __construct($_table = null)
    {
        if($_table !== null)
        {
            $this->from($_table);
        }
    }

    /**
     * @param $table
     * @return $this
     * @throws \Exception
     */
    public function from($table)
    {
        if (!is_string($table) && !is_array($table)) {
            throw new Exception('$table must be a string, array, or an instance of TableIdentifier');
        }

        if (is_array($table) && (!is_string(key($table)) || count($table) !== 1)) {
            throw new Exception('from() expects $table as an array is a single element associative array');
        }

        $this->_table = $table;
        return $this;
    }
    /**
     * @param int $limit
     * @return Select
     */
    public function limit($limit)
    {
        if (!is_numeric($limit)) {
            throw new Exception(sprintf(
                '%s expects parameter to be numeric, "%s" given',
                __METHOD__,
                (is_object($limit) ? get_class($limit) : gettype($limit))
            ));
        }

        $this->_limit = $limit;
        return $this;
    }

    /**
     * @param int $offset
     * @return Select
     */
    public function offset($offset)
    {
        if (!is_numeric($offset)) {
            throw new Exception(sprintf(
                '%s expects parameter to be numeric, "%s" given',
                __METHOD__,
                (is_object($offset) ? get_class($offset) : gettype($offset))
            ));
        }

        $this->_offset = $offset;
        return $this;
    }

}