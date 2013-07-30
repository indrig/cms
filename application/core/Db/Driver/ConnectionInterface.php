<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 12:33
 */
namespace Core\Db\Driver;

interface ConnectionInterface
{
    public function setDriver(DriverInterface $driver);
    public function getDriverName();
    public function getLastInsertId($name = null);
    public function prepare($sql);
    public function execute($sql);
    public function rollback();
    public function commit();
    public function beginTransaction();
    public function isConnected();
    public function disconnect();
    public function connect();
}