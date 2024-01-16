<?php

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH.'/vendor/autoload.php';

use League\Container\Container;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Sergei\PhpFramework\Http\Kernel;
use Sergei\PhpFramework\Http\Request;

$request = Request::createFromGlobals();
/** @var $container Container */
$container = require BASE_PATH.'/config/services.php';

try {
    $kernel = $container->get(Kernel::class);
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
    print_r($e->getMessage());
}
$response = $kernel->handle($request);
$response->send();
