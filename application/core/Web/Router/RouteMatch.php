<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 26.07.13
 * Time: 12:20
 */

namespace Core\Web\Router;

class RouteMatch
{
    protected $params = array();
    protected $matchedRouteName;
    protected $length;
    public function __construct(array $params, $length)
    {
        $this->params  = $params;
        $this->length  = $length;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setMatchedRouteName($name)
    {
        $this->matchedRouteName = $name;
        return $this;
    }

    /**
     * Get name of matched route.
     *
     * @return string
     */
    public function getMatchedRouteName()
    {
        return $this->matchedRouteName;
    }

    /**
     * Get all parameters.
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    public function merge(RouteMatch $match)
    {
        $this->params  = array_merge($this->params, $match->getParams());
        $this->length += $match->getLength();

        $this->matchedRouteName = $match->getMatchedRouteName();
        return $this;
    }

    public function getLength()
    {
        return $this->length;
    }

}