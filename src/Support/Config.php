<?php

namespace Do7a\Mvc\Support;


use ArrayAccess;

class Config implements ArrayAccess
{

    protected array $items = [];

    public function __construct($items)
    {
        foreach ($items as $key => $item)
        {
            $this->items[$key] = $item;
        }
    }

    public function get($key, $default = null)
    {
        if (is_array($key))
            return $this->getMany($key);

        return Arr::get($this->items, $key, $default);
    }

    public function getMany($keys): array
    {
        $config = [];

        foreach ($keys as $key => $default)
        {
            if (is_numeric($key))
                [$key, $default] = [$default, null];

            $config[$key] = Arr::get($this->items, $key, $default);
        }

        return $config;
    }


    public function set($key, $value = null): array
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value)
        {
            $this->items = Arr::set($this->items, $key, $value);
        }

        return  $this->items;
    }

    public function all(): array
    {
        return $this->items;
    }

    public function exists($key): bool
    {
        return Arr::exists($this->items, $key);
    }

    public function offsetGet( $offset)
    {
       return  $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value)
    {
        return $this->set($offset, $value);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->exists($offset);
    }

    public function offsetUnset(mixed $offset)
    {
        return $this->set($offset, null);
    }
}