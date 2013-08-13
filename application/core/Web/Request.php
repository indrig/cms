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
    /**#@-*/

    /**
     * @var string
     */
    protected $method = 'GET';

    private $path;
    private $query;
    private $fragment;
    private $preferredLanguages;
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

    public function getPost($name = null, $defaultValue = null)
    {
        if($name === null)
            return $_POST;

        return isset($_POST[$name]) ? $_POST[$name] : $defaultValue;
    }

    /**
     * Is this an OPTIONS method request?
     *
     * @return bool
     */
    public function isOptions()
    {
        return ($this->method === 'OPTIONS');
    }

    /**
     * Is this a PROPFIND method request?
     *
     * @return bool
     */
    public function isPropFind()
    {
        return ($this->method === 'PROPFIND');
    }

    /**
     * Is this a GET method request?
     *
     * @return bool
     */
    public function isGet()
    {
        return ($this->method === 'GET');
    }

    /**
     * Is this a HEAD method request?
     *
     * @return bool
     */
    public function isHead()
    {
        return ($this->method === 'HEAD');
    }

    /**
     * Is this a POST method request?
     *
     * @return bool
     */
    public function isPost()
    {
        return ($this->method === 'POST');
    }

    /**
     * Is this a PUT method request?
     *
     * @return bool
     */
    public function isPut()
    {
        return ($this->method === 'PUT');
    }

    /**
     * Is this a DELETE method request?
     *
     * @return bool
     */
    public function isDelete()
    {
        return ($this->method === 'DELETE');
    }

    /**
     * Is this a TRACE method request?
     *
     * @return bool
     */
    public function isTrace()
    {
        return ($this->method === 'TRACE');
    }

    /**
     * Is this a CONNECT method request?
     *
     * @return bool
     */
    public function isConnect()
    {
        return ($this->method === 'CONNECT');
    }

    /**
     * Is this a PATCH method request?
     *
     * @return bool
     */
    public function isPatch()
    {
        return ($this->method === 'PATCH');
    }

    /**
     * Получение подеживаемых языков по порядку
     * @return array
     */
    public function getPreferredLanguages()
    {
        if($this->preferredLanguages===null)
        {
            $sortedLanguages=array();
            if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && $n=preg_match_all('/([\w\-_]+)(?:\s*;\s*q\s*=\s*(\d*\.?\d*))?/',$_SERVER['HTTP_ACCEPT_LANGUAGE'],$matches))
            {
                $languages=array();

                for($i=0;$i<$n;++$i)
                {
                    $q=$matches[2][$i];
                    if($q==='')
                        $q=1;
                    if($q)
                        $languages[]=array((float)$q,$matches[1][$i]);
                }

                usort($languages, create_function('$a,$b','if($a[0]==$b[0]) {return 0;} return ($a[0]<$b[0]) ? 1 : -1;'));
                foreach($languages as $language)
                    $sortedLanguages[]=$language[1];
            }
            $this->preferredLanguages=$sortedLanguages;
        }
        return $this->preferredLanguages;
    }
}