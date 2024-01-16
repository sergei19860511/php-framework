<?php

use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Container;
use Sergei\PhpFramework\Http\Kernel;
use Sergei\PhpFramework\Routing\Router;
use Sergei\PhpFramework\Routing\RouterInterface;

$routes = include BASE_PATH.'/routes/web.php';

$container = new Container();

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)->addMethodCall('registerRoute', [new ArrayArgument($routes)]);

$container->add(Kernel::class)->addArgument(RouterInterface::class);

return $container;
