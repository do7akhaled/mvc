<?php


use Do7a\Mvc\Http\Route;

Route::get('/home', [\App\Controllers\HomeController::class, 'index']);