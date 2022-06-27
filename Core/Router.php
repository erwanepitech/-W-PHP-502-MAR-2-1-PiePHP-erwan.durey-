<?php

namespace Core;

class Router
{
    private static $routes;
    
    public static function connect($url, $route)
    {
        self::$routes[$url] = $route;
    }

    public static function get($url)
    {
        $array = array_combine(
            array_map("ucfirst", array_keys(self::$routes[$url])),
            array_map("ucfirst", array_values(self::$routes[$url]))
        );
        return $array;
    }
}
