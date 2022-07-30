<?php

namespace Do7a\Mvc;

use Do7a\Mvc\Http\Request;
use Do7a\Mvc\Http\Route;

class Application
{
    private Request $request;
    private Route $route;

    public function __construct()
    {
        $this->request = new Request();
        $this->route = new Route($this->request);
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