<?php

use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Controllers\RegisterController;
use Sergei\PhpFramework\Routing\Route;

return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/posts/{id:\d+}', [PostController::class, 'index']),
    Route::get('/post/create', [PostController::class, 'create']),
    Route::post('/posts', [PostController::class, 'store']),
    Route::get('/register', [RegisterController::class, 'createForm']),
    Route::post('/register', [RegisterController::class, 'store']),
];
