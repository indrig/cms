<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 12:29
 */
namespace Core\Db\Driver\Pdo;

use Core\Db\Driver\ConnectionInterface,
    Core\Db\Driver\DriverInterface;

class Connection implements ConnectionInterface
{
    /**
     * @var Driver
     */
    private $_driver            = null;
    /**
     * @var \PDO
     */
    private $_resource          = null;
    /**
     * @var string
     */
    private $_driverName        = null;
    /**
     * @var array
     */
    private $_config            = null;
    /**
     * @var bool
     */
    private $_in_transaction    = false;

    public function __construct($config)
    {
        $this->_config = $config;
    }

    public function setDriver(DriverInterface $driver)
    {
        $this->_driver = $driver;
        return $this;
    }

    public function connect()
    {
        if ($this->_resource)
        {
            return $this;
        }

        try {
            $this->_resource = new \PDO($this->_config['dsn'], $this->_config['username'], $this->_config['password'], $this->_config['options']);
            $this->_resource->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->_driverName = strtolower($this->_resource->getAttribute(\PDO::ATTR_DRIVER_NAME));
        } catch (\PDOException $e) {
            $code = $e->getCode();
            if (!is_long($code)) {
                $code = null;
            }
            throw new \Exception('Connect Error: ' . $e->getMessage(), $code, $e);
        }
        return $this;
    }

    /**
     * Is connected
     *
     * @return bool
     */
    public function isConnected()
    {
        return ($this->_resource instanceof \PDO);
    }

    /**
     * Disconnect
     *
     * @return Connection
     */
    public function disconnect()
    {
        if ($this->isConnected())
        {
            $this->_resource = null;
        }
        return $this;
    }

    /**
     * Set resource
     *
     * @param  \PDO $resource
     * @return Connection
     */
    public function setResource(\PDO $resource)
    {
        $this->resource = $resource;
        $this->driverName = strtolower($this->_resource->getAttribute(\PDO::ATTR_DRIVER_NAME));
        return $this;
    }

    /**
     * Get resource
     *
     * @return \PDO
     */
    public function getResource()
    {
        if (!$this->isConnected()) {
            $this->connect();
        }
        return $this->_resource;
    }

    /**
     * Begin transaction
     *
     * @return Connection
     */
    public function beginTransaction()
    {
        if (!$this->isConnected()) {
            $this->connect();
        }
        $this->_resource->beginTransaction();
        $this->inTransaction = true;
        return $this;
    }

    /**
     * Commit
     *
     * @return Connection
     */
    public function commit()
    {
        if (!$this->isConnected()) {
            $this->connect();
        }

        $this->_resource->commit();
        $this->inTransaction = false;
        return $this;
    }

    /**
     * Rollback
     *
     * @return Connection
     * @throws \Exception
     */
    public function rollback()
    {
        if (!$this->isConnected()) {
            throw new \Exception('Must be connected before you can rollback');
        }

        if (!$this->_in_transaction)
        {
            throw new \Exception('Must call beginTransaction() before you can rollback');
        }

        $this->_resource->rollBack();
        return $this;
    }

    /**
     * Execute
     *
     * @param $sql
     * @return Result
     * @throws \Exception
     */
    public function execute($sql)
    {
        if (!$this->isConnected()) {
            $this->connect();
        }



        $resultResource = $this->_resource->query($sql);



        if ($resultResource === false)
        {
            $errorInfo = $this->_resource->errorInfo();
            throw new \Exception($errorInfo[2]);
        }

        $result = $this->_driver->createResult($resultResource, $sql);
        return $result;

    }

    /**
     * Prepare
     *
     * @param string $sql
     * @return Statement
     */
    public function prepare($sql)
    {
        if (!$this->isConnected()) {
            $this->connect();
        }

        $statement = $this->_driver->createStatement($sql);
        return $statement;
    }

    /**
     * Get last generated id
     *
     * @param string $name
     * @return int|null|bool
     */
    public function getLastInsertId($name = null)
    {
        if ($name === null && $this->_driverName == 'pgsql')
        {
            return null;
        }

        try {
            return $this->_resource->lastInsertId($name);
        } catch (\Exception $e) {

        }
        return false;
    }

    /**
     * Get driver name
     *
     * @return null|string
     */
    public function getDriverName()
    {
        return $this->_driverName;
    }
}
