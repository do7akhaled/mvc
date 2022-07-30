<?php

if(!function_exists('env'))
{
    function env($key, $default = null)
    {
        return $_ENV[$key] ?? value($default);
    }
}


if(!function_exists('value'))
{
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (!function_exists('base_path'))
{
    function base_path($path = ''): string
    {
        return dirname(__DIR__) . '/../' . $path;
    }
}

if (!function_exists('view_path'))
{
    function view_path($path = ''): string
    {
        return base_path('views/' . $path);
    }
}

if (!function_exists('view'))
{
    function view($view,  $params = []): void
    {
        echo (new Do7a\Mvc\View\View())::make($view, $params);
    }
}

if (!function_exists('assets'))
{
    function assets($path = ''): string
    {
        return base_path('public/assets/' . $path);
    }
}

if (!function_exists('app'))
{
    function app(): \Do7a\Mvc\Application
    {
        static $instance = null;

        if ($instance === null)
        {
            $instance = new Do7a\Mvc\Application();
        }
        return $instance;
    }
}