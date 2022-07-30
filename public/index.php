<?php


require_once __DIR__ . './../src/Support/helpers.php';

require_once  base_path('vendor/autoload.php');

require_once base_path('routes/web.php');


$env = \Dotenv\Dotenv::createImmutable(base_path());

$env->load();

app()->run();