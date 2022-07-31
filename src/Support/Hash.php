<?php

namespace Do7a\Mvc\Support;

class Hash
{
    public function make($value): string
    {
        return password_hash($value, PASSWORD_BCRYPT);
    }

    public function token($value): string
    {
        return sha1($value . time());
    }
    public function  verify($value, $hashedValue): bool
    {
        return password_verify($value, $hashedValue);
    }
}