<?php

namespace Sergei\PhpFramework\Http;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Kernel
{
    public function handle(Request $request): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            $routes = include BASE_PATH.'/routes/web.php';

            foreach ($routes as $route) {
                $collector->addRoute(...$route);
            }
            /*$collector->get('/', function () {
                $content = "<h1>HELLO !!!</h1>";

                return new Response($content, 200, []);
            });
            $collector->get('/user/{id:\d+}', function (array $vars) {
                $content = "<h1>HELLO User: {$vars['id']}</h1>";

                return new Response($content, 200, []);
            });*/
        });

        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri());
        [$status, $handler, $vars] = $routeInfo;

        return $handler($vars);
    }
}