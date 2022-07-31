<?php


require_once __DIR__ . './../src/Support/helpers.php';

require_once  base_path('vendor/autoload.php');

require_once base_path('routes/web.php');


$env = \Dotenv\Dotenv::createImmutable(base_path());

$env->load();

$arr = [
    'db' =>[
        'connections' => [
            'default' => 'mysql',
            'mine' => 'test'
        ]
    ],
    'eloquent' => 'dd',
    'test' => []
];

$arr = \Do7a\Mvc\Support\Arr::flatten($arr);



dd($arr);

app()->run();


