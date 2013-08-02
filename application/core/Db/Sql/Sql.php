<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 02.08.13
 * Time: 12:45
 */
namespace Core\Db\Sql;

use Exception,
    Core\Db\Adapter;
class Sql
{
    protected $_adapter = null;

    /** @var string|array */
    protected $_table = null;

    public function __construct(Adapter $adapter, $table = null)
    {
        $this->_adapter = $adapter;
        if ($table) {
            $this->setTable($table);
        }
    }

    /**
    * @return null|Adapter
    */
    public function getAdapter()
    {
        return $this->_adapter;
    }

    /**
     * @param $table
     * @return $this
     * @throws Exception
     */
    public function setTable($table)
    {
        if (is_string($table) || is_array($table))
        {
            $this->_table = $table;
        } else {
            throw new Exception('Table must be a string or array.');
        }
        return $this;
    }

    public function getTable()
    {
        return $this->_table;
    }

    public function select($table = null)
    {
        if ($this->_table !== null && $table !== null) {
            throw new Exception(sprintf(
                'This Sql object is intended to work with only the table "%s" provided at construction time.',
                $this->_table
            ));
        }
        return new Select(($table) ?: $this->_table);
    }
}