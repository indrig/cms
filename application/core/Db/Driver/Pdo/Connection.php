<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Core\Db\Driver\Pdo;

use Exception,
    Core\Db\Driver\ConnectionInterface,
    Core\Db\Profiler;

class Connection implements ConnectionInterface, Profiler\ProfilerAwareInterface
{
    /**
     * @var Driver
     */
    protected $driver = null;

    /**
     * @var Profiler\ProfilerInterface
     */
    protected $profiler = null;

    /**
     * @var string
     */
    protected $driverName = null;

    /**
     * @var array
     */
    protected $connectionParameters = array();

    /**
     * @var \PDO
     */
    protected $resource = null;

    /**
     * @var bool
     */
    protected $inTransaction = false;

    /**
     * Constructor
     *
     * @param array|\PDO|null $connectionParameters
     * @throws Exception
     */
    public function __construct($connectionParameters = null)
    {
        if (is_array($connectionParameters)) {
            $this->setConnectionParameters($connectionParameters);
        } elseif ($connectionParameters instanceof \PDO) {
            $this->setResource($connectionParameters);
        } elseif (null !== $connectionParameters) {
            throw new Exception('$connection must be an array of parameters, a PDO object or null');
        }
    }

    /**
     * Set driver
     *
     * @param Driver $driver
     * @return Connection
     */
    public function setDriver(Driver $driver)
    {
        $this->driver = $driver;
        return $this;
    }

    /**
     * @param Profiler\ProfilerInterface $profiler
     * @return Connection
     */
    public function setProfiler(Profiler\ProfilerInterface $profiler)
    {
        $this->profiler = $profiler;
        return $this;
    }

    /**
     * @return null|Profiler\ProfilerInterface
     */
    public function getProfiler()
    {
        return $this->profiler;
    }

    /**
     * Get driver name
     *
     * @return null|string
     */
    public function getDriverName()
    {
        return $this->driverName;
    }

    /**
     * Set connection parameters
     *
     * @param array $connectionParameters
     * @return void
     */
    public function setConnectionParameters(array $connectionParameters)
    {
        $this->connectionParameters = $connectionParameters;
        if (isset($connectionParameters['dsn'])) {
            $this->driverName = substr($connectionParameters['dsn'], 0,
                strpos($connectionParameters['dsn'], ':')
            );
        } elseif (isset($connectionParameters['pdodriver'])) {
            $this->driverName = strtolower($connectionParameters['pdodriver']);
        } elseif (isset($connectionParameters['driver'])) {
            $this->driverName = strtolower(substr(
                str_replace(array('-', '_', ' '), '', $connectionParameters['driver']),
                3
            ));
        }
    }

    /**
     * Get connection parameters
     *
     * @return array
     */
    public function getConnectionParameters()
    {
        return $this->connectionParameters;
    }

    /**
     * Get current schema
     *
     * @return string
     */
    public function getCurrentSchema()
    {
        if (!$this->isConnected()) {
            $this->connect();
        }

        switch ($this->driverName) {
            case 'mysql':
                $sql = 'SELECT DATABASE()';
                break;
            case 'sqlite':
                return 'main';
            case 'pgsql':
            default:
                $sql = 'SELECT CURRENT_SCHEMA';
                break;
        }

        /** @var $result \PDOStatement */
        $result = $this->resource->query($sql);
        if ($result instanceof \PDOStatement) {
            return $result->fetchColumn();
        }
        return false;
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
        $this->driverName = strtolower($this->resource->getAttribute(\PDO::ATTR_DRIVER_NAME));
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
        return $this->resource;
    }

    /**
     * Connect
     *
     * @return Connection
     * @throws Exception
     * @throws Exception
     */
    public function connect()
    {
        if ($this->resource) {
            return $this;
        }

        $dsn = $username = $password = $hostname = $database = null;
        $options = array();
        foreach ($this->connectionParameters as $key => $value) {
            switch (strtolower($key)) {
                case 'dsn':
                    $dsn = $value;
                    break;
                case 'driver':
                    $value = strtolower($value);
                    if (strpos($value, 'pdo') === 0) {
                        $pdoDriver = strtolower(substr(str_replace(array('-', '_', ' '), '', $value), 3));
                    }
                    break;
                case 'pdodriver':
                    $pdoDriver = (string) $value;
                    break;
                case 'user':
                case 'username':
                    $username = (string) $value;
                    break;
                case 'pass':
                case 'password':
                    $password = (string) $value;
                    break;
                case 'host':
                case 'hostname':
                    $hostname = (string) $value;
                    break;
                case 'port':
                    $port = (int) $value;
                    break;
                case 'database':
                case 'dbname':
                    $database = (string) $value;
                    break;
                case 'driver_options':
                case 'options':
                    $value = (array) $value;
                    $options = array_diff_key($options, $value) + $value;
                    break;
                default:
                    $options[$key] = $value;
                    break;
            }
        }

        if (!isset($dsn) && isset($pdoDriver)) {
            $dsn = array();
            switch ($pdoDriver) {
                case 'sqlite':
                    $dsn[] = $database;
                    break;
                default:
                    if (isset($database)) {
                        $dsn[] = "dbname={$database}";
                    }
                    if (isset($hostname)) {
                        $dsn[] = "host={$hostname}";
                    }
                    if (isset($port)) {
                        $dsn[] = "port={$port}";
                    }
                    break;
            }
            $dsn = $pdoDriver . ':' . implode(';', $dsn);
        } elseif (!isset($dsn)) {
            throw new Exception(
                'A dsn was not provided or could not be constructed from your parameters',
                $this->connectionParameters
            );
        }

        try {
            $this->resource = new \PDO($dsn, $username, $password, $options);
            $this->resource->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->driverName = strtolower($this->resource->getAttribute(\PDO::ATTR_DRIVER_NAME));
        } catch (\PDOException $e) {
            $code = $e->getCode();
            if (!is_long($code)) {
                $code = null;
            }
            throw new Exception('Connect Error: ' . $e->getMessage(), $code, $e);
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
        return ($this->resource instanceof \PDO);
    }

    /**
     * Disconnect
     *
     * @return Connection
     */
    public function disconnect()
    {
        if ($this->isConnected()) {
            $this->resource = null;
        }
        return $this;
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
        $this->resource->beginTransaction();
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

        $this->resource->commit();
        $this->inTransaction = false;
        return $this;
    }

    /**
     * Rollback
     *
     * @return Connection
     * @throws Exception
     */
    public function rollback()
    {
        if (!$this->isConnected()) {
            throw new Exception('Must be connected before you can rollback');
        }

        if (!$this->inTransaction) {
            throw new Exception('Must call beginTransaction() before you can rollback');
        }

        $this->resource->rollBack();
        return $this;
    }

    /**
     * Execute
     *
     * @param $sql
     * @return Result
     * @throws Exception
     */
    public function execute($sql)
    {
        if (!$this->isConnected()) {
            $this->connect();
        }

        if ($this->profiler) {
            $this->profiler->profilerStart($sql);
        }

        $resultResource = $this->resource->query($sql);

        if ($this->profiler) {
            $this->profiler->profilerFinish($sql);
        }

        if ($resultResource === false) {
            $errorInfo = $this->resource->errorInfo();
            throw new Exception($errorInfo[2]);
        }

        $result = $this->driver->createResult($resultResource, $sql);
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

        $statement = $this->driver->createStatement($sql);
        return $statement;
    }

    /**
     * Get last generated id
     *
     * @param string $name
     * @return int|null|bool
     */
    public function getLastGeneratedValue($name = null)
    {
        if ($name === null && $this->driverName == 'pgsql') {
            return null;
        }

        try {
            return $this->resource->lastInsertId($name);
        } catch (\Exception $e) {
            // do nothing
        }
        return false;
    }
}
