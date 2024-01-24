<?php

namespace Sergei\PhpFramework\Routing;

use League\Container\Container;
use Sergei\PhpFramework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request, Container $container);

    public function registerRoute(array $routes);
}
