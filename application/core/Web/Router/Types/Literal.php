<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 26.07.13
 * Time: 11:27
 */
namespace Core\Web\Router\Types;

use Exception,
    Core\Web\Request,
    Core\Web\Router\RouteMatch,
    Core\Web\Router\RouteInterface;

class Literal implements RouteInterface
{
    /**
     * RouteInterface to match.
     *
     * @var string
     */
    protected $route;

    /**
     * Default values.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Создать новый точный маршрут
     *
     * @param  string $route
     * @param  array  $defaults
     */
    public function __construct($route, array $defaults = array())
    {
        $this->route    = $route;
        $this->defaults = $defaults;
    }

    public function match(Request $request, $pathOffset = null)
    {
        $path  = $request->getPath();

        //var_dump($path);

        if ($pathOffset !== null)
        {

            if ($pathOffset >= 0 && strlen($path) >= $pathOffset && !empty($this->route))
            {
                if (strpos($path, $this->route, $pathOffset) === $pathOffset)
                {//var_dump(new RouteMatch($this->defaults, strlen($this->route)));
                    return new RouteMatch($this->defaults, strlen($this->route));
                }
            }

            return null;
        }

        if ($path === $this->route)
        {
            return new RouteMatch($this->defaults, strlen($this->route));
        }

        return null;
    }

    /**
     * Создание маршрута
     *
     * @param array $options
     * @throws Exception
     */
    public static function factory($options = array())
    {
        if (!is_array($options))
        {
            throw new Exception(__METHOD__ . ' expects an array set of options');
        }

        if (!isset($options['route']))
        {
            throw new Exception('Missing "route" in options array');
        }

        if (!isset($options['defaults']))
        {
            $options['defaults'] = array();
        }
        return new static($options['route'], $options['defaults']);
    }
}