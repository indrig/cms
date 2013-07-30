<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 26.07.13
 * Time: 12:20
 */

namespace Core\Web\Router;

class RouteMatch
{
    protected $_params = array();
    protected $_matchedRouteName;
    protected $_length;
    public function __construct(array $params, $length)
    {
        $this->_params  = $params;
        $this->_length  = $length;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setMatchedRouteName($name)
    {
        $this->_matchedRouteName = $name;
        return $this;
    }

    /**
     * Get name of matched route.
     *
     * @return string
     */
    public function getMatchedRouteName()
    {
        return $this->_matchedRouteName;
    }

    /**
     * Get all parameters.
     *
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }

    public function merge(RouteMatch $match)
    {
        return $this;
    }

    public function getLength()
    {
        return $this->_length;
    }
}