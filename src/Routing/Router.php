<?php

namespace Sergei\PhpFramework\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Sergei\PhpFramework\Http\Exceptions\RouteNotAllowedException;
use Sergei\PhpFramework\Http\Exceptions\RouteNotFoundException;
use Sergei\PhpFramework\Http\Request;

use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    /**
     * @throws RouteNotFoundException
     * @throws RouteNotAllowedException
     */
    public function dispatch(Request $request): array
    {
        [$handlerRoute, $vars] = $this->extractRouteInfo($request);

        if (is_array($handlerRoute)) {
            [$controller, $method] = $handlerRoute;
            $handlerRoute = [new $controller, $method];
        }

        return [$handlerRoute, $vars];
    }

    /**
     * @throws RouteNotAllowedException
     * @throws RouteNotFoundException
     */
    private function extractRouteInfo($request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            $routes = include BASE_PATH.'/routes/web.php';

            foreach ($routes as $route) {
                $collector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri());

        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
            case Dispatcher::METHOD_NOT_ALLOWED:
                $methodList = implode(',', $routeInfo[1]);
                throw new RouteNotAllowedException("Supported HTTP Methods: $methodList");
            default:
                throw new RouteNotFoundException('Route not found');
        }
    }
}
