<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 12:13
 */
namespace Core\Base;
use Core\Base\Application;

abstract class Plugin
{
    protected  $_config;
    private  $_app;

    public function __construct($config, Application $app = null)
    {
        $this->_config = $config;
        $this->_app     = $app;
    }

    protected function app()
    {
        return $this->_app;
    }
}