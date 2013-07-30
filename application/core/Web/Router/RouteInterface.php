<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 26.07.13
 * Time: 10:52
 */
namespace Core\Web\Router;

use Core\Web\Request;

interface RouteInterface
{
    /**
     * Проверяет совпадение с маошрута
     *
     * @param  Request $request
     * @return RouteMatch|null
     */
    public function match(Request $request, $pathOffset = null);
    public static function factory($options = array());
}