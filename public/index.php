<?php

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH.'/vendor/autoload.php';

use League\Container\Container;
use Sergei\PhpFramework\Http\Kernel;
use Sergei\PhpFramework\Http\Request;

$request = Request::createFromGlobals();
/** @var $container Container */
$container = require BASE_PATH.'/config/services.php';

$kernel = $container->get(Kernel::class);

$response = $kernel->handle($request);
$response->send();

$kernel->clear($request, $response);
