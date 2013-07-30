<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 12:13
 */
namespace Core\Base;

abstract class Plugin
{
    protected  $_config;

    public function __construct($config)
    {
        $this->_config = $config;
    }
}