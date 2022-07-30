<?php

namespace Do7a\Mvc\Http;


class Request
{
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function uri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function path() : string
    {
        return parse_url($this->uri(), PHP_URL_PATH);
    }


}