<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 13:32
 */

namespace Core\Db;

use Core\Base\Plugin;

class DataBase extends Plugin
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
     * @var Driver\StatementInterface
     */
    private $_lastPreparedStatement = null;

    public function __construct($config)
    {
        parent::__construct($config);
        $driver = $this->createDriver();
        $driver->checkEnvironment();
        $this->_driver = $driver;
    }

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