<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 12:34
 */
namespace Core\Db\Driver;

interface DriverInterface
{
    public function checkEnvironment();
    public function createResult($resource, $context = null);
    public function createStatement($sqlOrResource = null);
}