<?php

namespace Sergei\PhpFramework\Http\Middleware;

use Psr\Container\ContainerInterface;
use Sergei\PhpFramework\Http\Request;
use Sergei\PhpFramework\Http\Response;
use Sergei\PhpFramework\Routing\RouterInterface;

class RouteMiddleware implements MiddlewareInterface
{
    public function __construct(
        private RouterInterface $router,
        private ContainerInterface $container
    )
    {
    }

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);

            return call_user_func_array($routeHandler, $vars);
    }
}