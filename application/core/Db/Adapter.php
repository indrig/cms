<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 02.08.13
 * Time: 12:06
 */
namespace Core\Db;

class Adapter
{
    /**
     * Query Mode Constants
     */
    const QUERY_MODE_EXECUTE = 'execute';
    const QUERY_MODE_PREPARE = 'prepare';

    /**
     * @var Driver\Pdo\Driver|null
     */
    private $_driver    = null;

    /**
     *
     *
     * @return Driver\Pdo\Driver
     * @throws \Exception
     */
    protected function createDriver()
    {
        if (!isset($this->_config['driver']))
        {
            throw new \Exception(__FUNCTION__ . ' expects a "driver" key to be present inside the parameters');
        }

        if ($this->_config['driver'] instanceof Driver\DriverInterface)
        {
            return $this->_config['driver'];
        }

        $driverName = strtolower($this->_config['driver']);

        switch($driverName)
        {
            case 'pdo':
            default:
                if ($driverName == 'pdo' || strpos($driverName, 'pdo') === 0)
                {
                    $driver = new Driver\Pdo\Driver($this->_config);
                }
        }

        if (!isset($driver) || !$driver instanceof Driver\DriverInterface)
        {
            throw new \Exception('DriverInterface expected', null, null);
        }

        return $driver;
    }

    /**
     * getDriver()
     *
     * @throws \Exception
     * @return Driver\DriverInterface
     */
    public function getDriver()
    {
        if ($this->_driver == null)
        {
            throw new \Exception('Driver has not been set or configured for this adapter.');
        }
        return $this->_driver;
    }

    public function prepareStatementForSqlObject(PreparableSqlInterface $sqlObject, StatementInterface $statement = null)
    {
        $statement = ($statement) ?: $this->getDriver()->createStatement();

        if ($this->sqlPlatform) {
            $this->sqlPlatform->setSubject($sqlObject);
            $this->sqlPlatform->prepareStatement($this->adapter, $statement);
        } else {
            $sqlObject->prepareStatement($this->adapter, $statement);
        }

        return $statement;
    }


    /**
     *
     *
     * @param string $sql
     * @param string $parametersOrQueryMode
     */
    public function query($sql, $parametersOrQueryMode = self::QUERY_MODE_PREPARE)
    {
        if (is_string($parametersOrQueryMode) && in_array($parametersOrQueryMode, array(self::QUERY_MODE_PREPARE, self::QUERY_MODE_EXECUTE)))
        {
            $mode = $parametersOrQueryMode;
            $parameters = null;
        }
        elseif (is_array($parametersOrQueryMode))
        {
            $mode = self::QUERY_MODE_PREPARE;
            $parameters = $parametersOrQueryMode;
        }
        else
        {
            throw new \Exception('Parameter 2 to this method must be a flag, an array, or ParameterContainer');
        }

        if ($mode == self::QUERY_MODE_PREPARE)
        {
            $this->_lastPreparedStatement = null;
            $this->_lastPreparedStatement = $this->_driver->createStatement($sql);
            $this->_lastPreparedStatement->prepare();
            if (is_array($parameters))
            {
                $this->_lastPreparedStatement->setParameterContainer($parameters);
                $result = $this->_lastPreparedStatement->execute();
            } else {
                return $this->_lastPreparedStatement;
            }
        } else {
            $result = $this->_driver->getConnection()->execute($sql);
        }

        return $result;
    }
}