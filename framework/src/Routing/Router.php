<?php

namespace Sergei\PhpFramework\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use League\Container\Container;
use Sergei\PhpFramework\Controller\AbstractController;
use Sergei\PhpFramework\Http\Exceptions\RouteNotAllowedException;
use Sergei\PhpFramework\Http\Exceptions\RouteNotFoundException;
use Sergei\PhpFramework\Http\Request;

use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    private array $routes;

    /**
     * @throws RouteNotFoundException
     * @throws RouteNotAllowedException
     */
    public function dispatch(Request $request, Container $container): array
    {
        [$handlerRoute, $vars] = $this->extractRouteInfo($request);

        if (is_array($handlerRoute)) {
            [$controllerId, $method] = $handlerRoute;
            $controller = $container->get($controllerId);

            if (is_subclass_of($controller, AbstractController::class)) {
                $controller->setRequest($request);
            }
            $handlerRoute = [$controller, $method];
        }

        return [$handlerRoute, $vars];
    }

    public function registerRoute(array $routes): void
    {
        $this->routes = $routes;
    }

    /**
     * @throws RouteNotAllowedException
     * @throws RouteNotFoundException
     */
    private function extractRouteInfo($request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            foreach ($this->routes as $route) {
                $collector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri());

        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
            case Dispatcher::METHOD_NOT_ALLOWED:
                $methodList = implode(',', $routeInfo[1]);
                $exception = new RouteNotAllowedException("Supported HTTP Methods: $methodList");
                $exception->setStatusCode(405);
                throw $exception;
            default:
                $exception = new RouteNotFoundException('Route not found');
                $exception->setStatusCode(404);
                throw $exception;
        }
    }
}
