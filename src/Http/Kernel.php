<?php

namespace Sergei\PhpFramework\Http;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Kernel
{
    public function handle(Request $request): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $route) {
            $route->get('/', function () {
                $content = "<h1>HELLO !!!</h1>";

                return new Response($content, 200, []);
            });
            $route->get('/user/{id:\d+}', function (array $vars) {
                $content = "<h1>HELLO User: {$vars['id']}</h1>";

                return new Response($content, 200, []);
            });
        });

        $routeInfo = $dispatcher->dispatch($request->server['REQUEST_METHOD'], $request->server['REQUEST_URI']);
        [$status, $handler, $vars] = $routeInfo;

        return $handler($vars);
    }
}