<?php

namespace Sergei\PhpFramework\Routing;

use FastRoute\RouteCollector;
use Sergei\PhpFramework\Http\Request;

use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{

    public function dispatch(Request $request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            $routes = include BASE_PATH.'/routes/web.php';

            foreach ($routes as $route) {
                $collector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri());
        [$status, [$controller, $method], $vars] = $routeInfo;

         return [[new $controller, $method], $vars];
    }
}