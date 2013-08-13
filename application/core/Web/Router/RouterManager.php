<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 26.07.13
 * Time: 10:41
 */

namespace Core\Web\Router;

use Exception;
use Core\Web\Request;

class RouterManager
{
    protected $routes;
    protected $typePrototype   = array();
    protected $typeClass  = array();
    public function __construct()
    {
        $this->routes = new PriorityList();

        //Иницилизация списка шаблонов
        foreach (
            array(
                'literal'   => __NAMESPACE__ . '\Types\Literal',
                'segment'   => __NAMESPACE__ . '\Types\Segment',
                'part'      => __NAMESPACE__ . '\Types\Part',
            ) as $name => $class
        )
        {
            $this->typeClass[$name] = $class;
        };
    }

    /**
     * Добавление маршрутов
     *
     * @see    RouteStackInterface::addRoutes()
     * @param  array $routes
     * @return RouterManager
     * @throws Exception
     */
    public function addRoutes($routes)
    {
        if (!is_array($routes)) {
            throw new Exception('addRoutes expects an array set of routes');
        }

        foreach ($routes as $name => $route)
        {
            $this->addRoute($name, $route);
        }

        return $this;
    }

    /**
     * Добавляет маршрут
     *
     * @see    RouteStackInterface::addRoute()
     * @param  string  $name
     * @param  mixed   $route
     * @param  int $priority
     * @return RouterManager
     */
    public function addRoute($name, $route, $priority = null)
    {

        if (!$route instanceof RouteInterface)
        {
            $route = $this->routeFromArray($route);
        }

        if ($priority === null && isset($route->priority))
        {
            $priority = $route->priority;
        }

        $this->routes->insert($name, $route, $priority);

        return $this;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Create a route from array specifications.
     *
     * @param  array $specs
     * @return RouterManager
     * @throws Exception
     */
    public  function routeFromArray($specs)
    {
        if (!is_array($specs))
        {
            throw new Exception('Route definition must be an array');
        }

        //Поле типа обезательно
        if (!isset($specs['type']))
        {
            throw new Exception('Missing "type" option');
        }

        if (!isset($specs['options']))
        {
            $specs['options'] = array();
        }

        if(!IsSet($this->typeClass[$specs['type']]))
        {
            throw new Exception('Incorrect "type" option');
        }


        $route = call_user_func_array(array($this->typeClass[$specs['type']], 'factory'), array($specs['options']));

        if (isset($specs['priority']))
        {
            $route->priority = $specs['priority'];
        }
        if (isset($specs['child_routes']))
        {
            $options = array(
                'route'         => $route,
                'manager'       => $this,
                'may_terminate' => (isset($specs['may_terminate']) && $specs['may_terminate']),
                'child_routes'  => $specs['child_routes'],
            );
            $route = call_user_func_array(array('\\Core\\Web\\Router\\Types\\Part', 'factory'), array($options));

        }
        return $route;
    }

    /**
     * Провреяет маршруты на смовпадение с запросом
     * @param Request $request
     *
     */
    public function match(Request $request)
    {

        /**
         * @var RouteInterface $route
         */
        foreach ($this->routes as $name => $route)
        {
            if(($match = $route->match($request)) !== null)
            {
                $match->setMatchedRouteName($name);
                return $match;
            }
        }

        return null;

    }


}