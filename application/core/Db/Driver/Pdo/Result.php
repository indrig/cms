<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 12:31
 */
namespace Core\Db\Driver\Pdo;

use Core\Db\Driver\ResultInterface;

class Result implements ResultInterface
{
    /**
     * @var mixed
     */
    protected $_generatedValue = null;

    /**
     * @var \PDOStatement
     */
    protected $_resource = null;

    /**
     * @var null
     */
    protected $_rowCount = null;

    /**
     * Initialize
     *
     * @param  \PDOStatement $resource
     * @param               $generatedValue
     * @param  int          $rowCount
     * @return Result
     */
    public function initialize(\PDOStatement $resource, $generatedValue, $rowCount = null)
    {
        $this->_resource        = $resource;
        $this->_generatedValue  = $generatedValue;
        $this->_rowCount        = $rowCount;
        return $this;
    }

    public function fetch()
    {
        return $this->_resource->fetch();
    }

    public function count()
    {
        if (is_int($this->_rowCount))
        {
            return $this->_rowCount;
        }

        $this->rowCount = (int) $this->_resource->rowCount();

        return $this->_rowCount;
    }
}
