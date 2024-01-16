<?php

use League\Container\Container;
use Sergei\PhpFramework\Http\Kernel;
use Sergei\PhpFramework\Routing\Router;
use Sergei\PhpFramework\Routing\RouterInterface;

$container = new Container();

$container->add(RouterInterface::class, Router::class);

$container->add(Kernel::class)->addArgument(RouterInterface::class);

return $container;
