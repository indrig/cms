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
    protected  $config;
    private  $app;

    public function __construct($config, Application $app = null)
    {
        $this->config = $config;
        $this->app     = $app;
    }

    protected function app()
    {
        return $this->app;
    }
}