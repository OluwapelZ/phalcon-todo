<?php
/**
 * Created by PhpStorm.
 * User: oluwapelumi.olaoye
 * Date: 2/3/18
 * Time: 10:35 AM
 */

class Utils
{
    /**
     *
     * return v5 endpoints
     *
     * @param $router
     * @return array
     */
    public static function getRoutes($router)
    {
        $routes = [];
        foreach ($router->getRoutes() as $route) {
            if (self::stringStartsWith('/v5/', $route->getPattern())) {
                $routes[] = $route;
            }
        }
        return $routes;
    }

    /**
     *
     * return v5 endpoints names
     *
     * @param $router
     * @return array
     */
    public static function getRouteNames($router)
    {
        $routes = [];
        foreach ($router->getRoutes() as $route) {
            if (self::stringStartsWith('/v5/', $route->getPattern())) {
                $routes[] = $route->getName();
            }
        }
        return $routes;
    }

    /**
     * checks if a string is a prefix to another string
     * @param $needle
     * @param $haystack
     * @return int
     */
    public static function stringStartsWith($needle, $haystack)
    {
        return preg_match('/^' . preg_quote($needle, '/') . '/', $haystack);
    }

    /**
     * @param $params
     * @return array
     */
    public static function stripHtmlTags($params)
    {
        return array_map(function ($v) {
            return strip_tags($v);
        }, $params);
    }
}