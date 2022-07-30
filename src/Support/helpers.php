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
    function view($view,  $params = [])
    {
        return (new Do7a\Mvc\View\View())::make($view, $params);
    }
}

if (!function_exists('assets'))
{
    function assets($path = ''): string
    {
        return base_path('public/assets/' . $path);
    }
}