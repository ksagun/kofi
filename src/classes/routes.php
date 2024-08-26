<?php

class Routes
{

    public static $current_route;
    public static $route_params;
    public static $query_params;
    public static $selected_route;

    protected static function set_current_route($url)
    {
        self::$current_route = $url;
    }

    protected static function set_route_params($params)
    {
        self::$route_params = $params;
    }

    protected static function set_query_params($query)
    {
        self::$query_params = $query;
    }

    protected static function set_selected_route($route)
    {
        self::$selected_route = $route;
    }
}
