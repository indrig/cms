<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Indrig
 * Date: 30.07.13
 * Time: 23:43
 * To change this template use File | Settings | File Templates.
 */
namespace Core\Cache;

use Core\Base\Application,Core\Base\Plugin;

class Cache extends Plugin
{
    private $_cache;

    public function __construct($config, Application $app)
    {
        parent::__construct($config, $app);

        $this->_cache = $this->createCache();
    }

    private function createCache()
    {
    }
}