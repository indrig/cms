<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 14:19
 */
namespace Core\Db\Driver\Pdo;

use Core\Db\Driver\DriverInterface;
use Core\Db\Driver\StatementInterface;

class Statement implements StatementInterface
{
    /**
     * @var \PDO
     */
    protected $_pdo = null;

    /**
     * @var DriverInterface
     */
    protected $_driver = null;

    /**
     * @var \PDOStatement
     */
    protected $_resource = null;

    /**
     * @var \PDOStatement
     */
    protected $_sql = null;

    /**
     * @var bool
     */
    protected $_isPrepared = false;
    /**
     * Initialize
     *
     * @param  \PDO $connectionResource
     * @return Statement
     */
    public function initialize(\PDO $connectionResource)
    {
        $this->_pdo = $connectionResource;
        return $this;
    }

    /**
     * Set resource
     *
     * @param  \PDOStatement $pdoStatement
     * @return Statement
     */
    public function setResource(\PDOStatement $pdoStatement)
    {
        $this->_resource = $pdoStatement;
        return $this;
    }


    /**
     * Get resource
     *
     * @return mixed
     */
    public function getResource()
    {
        return $this->_resource;
    }

    /**
     * Set sql
     *
     * @param string $sql
     * @return Statement
     */
    public function setSql($sql)
    {
        $this->_sql = $sql;
        return $this;
    }

    /**
     * Get sql
     *
     * @return string
     */
    public function getSql()
    {
        return $this->_sql;
    }


    /**
     * Perform a deep clone
     * @return Statement A cloned statement
     */
    public function __clone()
    {

        $this->_resource = null;
        $this->_isPrepared = false;
    }

    /**
     * @param string $sql
     * @throws \Exception
     */
    public function prepare($sql = null)
    {
        if ($this->_isPrepared) {
            throw new \Exception('This statement has been prepared already');
        }

        if ($sql == null) {
            $sql = $this->_sql;
        }

        $this->resource = $this->_pdo->prepare($sql);

        if ($this->_resource === false) {
            $error = $this->_pdo->errorInfo();
            throw new \Exception($error[2]);
        }
        $this->isPrepared = true;
    }

    /**
     * @return bool
     */
    public function isPrepared()
    {
        return $this->_isPrepared;
    }

    /**
     * @param mixed $parameters
     * @throws \Exception
     * @return Result
     */
    public function execute($parameters = null)
    {
        if (!$this->_isPrepared)
        {
            $this->prepare();
        }


        try {
            $this->_resource->execute();
        } catch (\PDOException $e) {

            throw new \Exception('Statement could not be executed', null, $e);
        }



        $result = $this->_driver->createResult($this->_resource, $this);
        return $result;
    }
}