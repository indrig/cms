<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 16:13
 */
namespace Core\Web;

use Core\Base\Plugin;

class Request extends Plugin
{
    private $_path;
    private $_query;
    private $_fragment;
    public function __construct($config)
    {
        $arUrl = parse_url($_SERVER['REQUEST_URI']);

        $this->_path = IsSet($arUrl['path']) ? $arUrl['path'] : '';
        $this->_query = IsSet($arUrl['query']) ? $arUrl['query'] : '';
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->_path;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->_query;
    }

}