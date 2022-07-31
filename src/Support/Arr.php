<?php

namespace Do7a\Mvc\Support;

use Exception;

class Arr
{
    public static function only(array $array, array|string $keys): array
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }

    public static function except(array $array, array|string $keys): array
    {
        return array_diff_key($array, array_flip((array) $keys));
    }

    public static function accessible($value): bool
    {
        return is_array($value) || $value instanceof \ArrayAccess;
    }


    public static function exists($array, $key): bool
    {
        if ($array instanceof \ArrayAccess)
            return $array->offsetExists($key);

        return array_key_exists($key, $array);
    }


    public static function get(array $array, string $key = null, $default = null)
    {
        if (is_null($key))
            return $array;

        if (array_key_exists($key, $array))
            return $array[$key];


        foreach (explode('.', $key) as $segment)
        {
            if (self::exists($array, $segment) && self::accessible($array))
                $array = $array[$segment];
            else
                return $default;

        }

        return $array;
    }

    public static function has($array, $key) : bool
    {
        if (is_null($key))
            return false;

        if (self::exists($array, $key))
            return true;


        foreach (explode('.', $key) as $segment)
        {
            if (self::accessible($array) && self::exists($array, $segment))
                $array = $array[$segment];
            else
                return false;
        }

        return true;
    }


    public static function last(array $array, callable $callback = null, $default = null)
    {
        $last = empty($array) ? value($default) : end($array);


        if (is_null($callback))
            return $last;

        return $callback($last);
    }

    public static function first(array $array, callable $callback = null, $default = null)
    {
        return self::last(array_reverse($array), $callback, $default);
    }

    public static function forget($array, $keys)
    {
        $keys = (array) $keys;

        if (count($keys) === 0)
            return $array;


        $subArray = &$array;

        foreach ($keys as $key) {
            if (static::exists($array, $key)) {
                unset($array[$key]);
                continue;
            }

            $parts = explode('.', $key);


            foreach ($parts as $part)
            {
                if (self::exists($subArray, $part) && self::accessible($subArray))
                {
                    if ( $part !=  end($parts))
                        $subArray = &$subArray[$part];
                } else{
                    continue 2;
                }


            }
            if (self::exists($subArray, end($parts)))
                unset($subArray[end($parts)]);
        }
        return $array;
    }



    public static function set(array $array, $key, $value) : array
    {
        if (is_null($key))
            return $array;

        if (self::exists($array, $key))
        {
            $array[$key] = $value;
            return $array;
        }

        $subArray = &$array;
        $segments = explode('.', $key);
        foreach ( $segments as $segment)
        {
            if (self::exists($subArray, $segment) && self::accessible($subArray[$segment]))
            {
                if ($segment != end($segments))
                    $subArray = &$subArray[$segment];
            } else {
                return $array;
            }


        }

        if (self::exists($subArray, end($segments)))
            $subArray[end($segments)] = $value;

        return $array;
    }


    public static function flatten(array $array, $depth = INF) :array
    {
        $result = [];


        foreach ($array as $item)
        {
            if (!is_array($item))
                $result[] = $item;
            else if ($depth == 1)
                $result = array_merge($result, array_values($item));
            else
                $result = array_merge($result, self::flatten($item, $depth - 1));
        }

        return $result;




    }


}