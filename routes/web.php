<?php

use App\Controllers\HomeController;
use App\Controllers\PostController;
use Sergei\PhpFramework\Routing\Route;

return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/posts/{id:\d+}', [PostController::class, 'index']),
    Route::get('/post/create', [PostController::class, 'create']),

];
