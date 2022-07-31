<?php

namespace Do7a\Mvc;

use Do7a\Mvc\Http\Request;
use Do7a\Mvc\Http\Route;
use Do7a\Mvc\Support\Config;

class Application
{
    private Request $request;
    private Route $route;
    private Config $config;

    public function __construct()
    {
        $this->request = new Request();
        $this->route = new Route($this->request);
        $this->config = new Config($this->loadConfigurations());
    }

    private function loadConfigurations() : array
    {
        $items = [];
        foreach (scandir(config_path()) as $file)
        {
            if (in_array($file, ['.', '..']))
                continue;

            $items[explode('.', $file)[0]] = require config_path($file);
        }

        return $items;
    }


    public function run(): void
    {
        $this->route->resolve();
    }

    public function __get(string $name)
    {
        if (property_exists($this, $name))
            return $this->$name;
    }


}