<?php

namespace Do7a\Mvc\Http;

use Do7a\Mvc\View\View;

class Route
{
    protected static array $routes = [];
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public static function get($route, $action): void
    {
        self::$routes['GET'][$route] = $action;
    }

    public static function post($route, $action): void
    {
        self::$routes['post'][$route] = $action;
    }


    public function resolve()
    {
        $path = $this->request->path();
        $method = $this->request->method();
        $action =  self::$routes[$method][$path] ?? false;

        if (!$action)
            return View::makeError(404);

        if ($action instanceof \Closure)
            return call_user_func_array($action, []);

        if (is_array($action))
            return call_user_func([ new $action[0], $action[1] ]);

        if (is_string($action))
        {
            [$controller, $method] = explode('@', $action);
            return call_user_func([ new $controller, $method ]);
        }


    }
}