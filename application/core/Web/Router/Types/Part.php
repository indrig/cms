<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 26.07.13
 * Time: 12:29
 */
namespace Core\Web\Router\Types;

use Exception,
    Core\Web\Request,
    Core\Web\Router\RouterManager,
    Core\Web\Router\RouteMatch,
    Core\Web\Router\RouteInterface;

class Part extends RouterManager implements RouteInterface
{
    /**
     * RouteInterface to match.
     *
     * @var RouteInterface
     */
    protected $_route;

    /**
     * Whether the route may terminate.
     *
     * @var bool
     */
    protected $_mayTerminate;

    /**
     * Child routes.
     *
     * @var mixed
     */
    protected $_childRoutes;

   // protected $_manager;

    /**
     * Create a new part route.
     *
     * @param  mixed              $route
     * @param  bool               $mayTerminate
     * @param  array|null         $childRoutes
     */
    public function __construct($route, $mayTerminate, array $childRoutes = null)
    {
        parent::__construct();
        if (!$route instanceof RouteInterface)
        {
            $route = $this->routeFromArray($route);
        }


        $this->_route        = $route;
        $this->_mayTerminate = $mayTerminate;
        $this->_childRoutes  = $childRoutes;
        //$this->_manager      = $manager;
    }

    /**

     *
     * @param  mixed $options
     * @return Part
     * @throws Exception
     */
    public static function factory($options = array())
    {
        if (!is_array($options)) {
            throw new Exception(__METHOD__ . ' expects an array of options');
        }

        if (!isset($options['route'])) {
            throw new Exception('Missing "route" in options array');
        }

        if (!isset($options['manager'])) {
            throw new Exception('Missing "manager" in options array');
        }

        if (!isset($options['may_terminate'])) {
            $options['may_terminate'] = false;
        }

        if (!isset($options['child_routes']) || !$options['child_routes']) {
            $options['child_routes'] = null;
        }

        return new static(
            $options['route'],
            $options['may_terminate'],
            $options['child_routes'],
            $options['manager']
        );
    }

    public function match(Request $request, $pathOffset = null)
    {
        if ($pathOffset === null)
        {
            $pathOffset = 0;
        }

        $match = $this->_route->match($request, $pathOffset);
        if($match !== null)
        {
            if ($this->_childRoutes !== null)
            {
                $this->addRoutes($this->_childRoutes);
                $this->_childRoutes = null;
            }
            $nextOffset = $pathOffset + $match->getLength();
            $pathLength = strlen($request->getPath());
            /**
             * @var RouteInterface $route
             */
            foreach ($this->_routes as $name => $route)
            {

                if (($subMatch = $route->match($request, $nextOffset)) instanceof RouteMatch)
                {
                    //var_dump('asf');
                    if ($match->getLength() + $subMatch->getLength() + $pathOffset === $pathLength) {
                        return $match->merge($subMatch)->setMatchedRouteName($name);
                    }

                }
            }
        }
        return null;
    }

}