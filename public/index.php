<?php

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH.'/vendor/autoload.php';

use Sergei\PhpFramework\Http\Kernel;
use Sergei\PhpFramework\Http\Request;
use Sergei\PhpFramework\Routing\Router;

$request = Request::createFromGlobals();
$container = require BASE_PATH . '/config/services.php';
dd($container);
$router = new Router();
$kernel = new Kernel($router);
$response = $kernel->handle($request);
$response->send();
