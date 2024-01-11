<?php

use App\Controllers\HomeController;
use App\Controllers\PostController;
use Sergei\PhpFramework\Http\Response;
use Sergei\PhpFramework\Routing\Route;

return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/posts/{id:\d+}', [PostController::class, 'index']),
    Route::get('/hello/{name}', function (string $name) {
        return new Response("Привет $name");
    }),
];
