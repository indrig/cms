<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 12:31
 */
namespace Core\Db\Driver\Pdo;

use Core\Db\Driver\DriverInterface;

class Driver implements DriverInterface
{
    /**
     * @var Connection
     */
    protected $_connection          = null;

    /**
     * @var Statement
     */
    protected $_statementPrototype = null;

    /**
     * @var Result
     */
    protected $_resultPrototype    = null;

    /**
     * Конструктор
     * @param $connection Параметры соединения
     */
    public function __construct($connection)
    {
        if (!$connection instanceof Connection)
        {
            $connection = new Connection($connection);
        }

        $this->registerConnection($connection);

        $this->_statement_prototype     = new Statement();
        $this->_result_prototype        = new Result();

        //var_dump($this->_statement_prototype );
    }

    /**
     * Register connection
     *
     * @param  Connection $connection
     * @return Driver
     */
    public function registerConnection(Connection $connection)
    {
        $this->_connection = $connection;
        $this->_connection->setDriver($this);
        return $this;
    }

    /**
     * Проверка окружения PHP
     */
    public function checkEnvironment()
    {
        if (!extension_loaded('PDO'))
        {
            throw new \Exception('The PDO extension is required for this adapter but the extension is not loaded');
        }
    }

    /**
     * @param resource $resource
     * @param mixed $context
     * @return Result
     */
    public function createResult($resource, $context = null)
    {
        $result = clone $this->_resultPrototype;
        $rowCount = null;

        $result->initialize($resource, $this->_connection->getLastInsertId(), $rowCount);
        return $result;
    }

    /**
     * @param string|\PDOStatement $sqlOrResource
     * @return Statement
     */
    public function createStatement($sqlOrResource = null)
    {
        $statement = clone $this->_statementPrototype;
        if ($sqlOrResource instanceof \PDOStatement) {
            $statement->setResource($sqlOrResource);
        } else {
            if (is_string($sqlOrResource)) {
                $statement->setSql($sqlOrResource);
            }
            if (!$this->_connection->isConnected()) {
                $this->_connection->connect();
            }
            $statement->initialize($this->_connection->getResource());
        }
        return $statement;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->_connection;
    }
}
