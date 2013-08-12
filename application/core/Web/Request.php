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
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_GET     = 'GET';
    const METHOD_HEAD    = 'HEAD';
    const METHOD_POST    = 'POST';
    const METHOD_PUT     = 'PUT';
    const METHOD_DELETE  = 'DELETE';
    const METHOD_TRACE   = 'TRACE';
    const METHOD_CONNECT = 'CONNECT';
    const METHOD_PATCH   = 'PATCH';
    const METHOD_PROPFIND= 'PROPFIND';
    /**#@-*/

    /**
     * @var string
     */
    protected $method = self::METHOD_GET;

    private $path;
    private $query;
    private $fragment;
    public function __construct($config)
    {
        $arUrl = parse_url($_SERVER['REQUEST_URI']);

        $this->path = IsSet($arUrl['path']) ? $arUrl['path'] : '';
        $this->query = IsSet($arUrl['query']) ? $arUrl['query'] : '';

        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    public function getPost()
    {
        return $_POST;
    }

    /**
     * Is this an OPTIONS method request?
     *
     * @return bool
     */
    public function isOptions()
    {
        return ($this->method === self::METHOD_OPTIONS);
    }

    /**
     * Is this a PROPFIND method request?
     *
     * @return bool
     */
    public function isPropFind()
    {
        return ($this->method === self::METHOD_PROPFIND);
    }

    /**
     * Is this a GET method request?
     *
     * @return bool
     */
    public function isGet()
    {
        return ($this->method === self::METHOD_GET);
    }

    /**
     * Is this a HEAD method request?
     *
     * @return bool
     */
    public function isHead()
    {
        return ($this->method === self::METHOD_HEAD);
    }

    /**
     * Is this a POST method request?
     *
     * @return bool
     */
    public function isPost()
    {
        return ($this->method === self::METHOD_POST);
    }

    /**
     * Is this a PUT method request?
     *
     * @return bool
     */
    public function isPut()
    {
        return ($this->method === self::METHOD_PUT);
    }

    /**
     * Is this a DELETE method request?
     *
     * @return bool
     */
    public function isDelete()
    {
        return ($this->method === self::METHOD_DELETE);
    }

    /**
     * Is this a TRACE method request?
     *
     * @return bool
     */
    public function isTrace()
    {
        return ($this->method === self::METHOD_TRACE);
    }

    /**
     * Is this a CONNECT method request?
     *
     * @return bool
     */
    public function isConnect()
    {
        return ($this->method === self::METHOD_CONNECT);
    }

    /**
     * Is this a PATCH method request?
     *
     * @return bool
     */
    public function isPatch()
    {
        return ($this->method === self::METHOD_PATCH);
    }
}