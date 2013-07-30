<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 12:34
 */
namespace Core\Db\Driver;

interface ResultInterface
{
    public function fetch();
    public function count();
}