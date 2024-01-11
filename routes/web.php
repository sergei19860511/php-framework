<?php

use Sergei\PhpFramework\Routing\Route;

return [
    Route::get('/', ['HomeController::class', 'index'])
];
