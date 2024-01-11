<?php

use App\Controllers\HomeController;
use Sergei\PhpFramework\Routing\Route;

return [
    Route::get('/', [HomeController::class, 'index'])
];
