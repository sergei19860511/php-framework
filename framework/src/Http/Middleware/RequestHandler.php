<?php

namespace Sergei\PhpFramework\Http\Middleware;

use Psr\Container\ContainerInterface;
use Sergei\PhpFramework\Http\Request;
use Sergei\PhpFramework\Http\Response;

class RequestHandler implements RequestHandlerInterface
{
    private array $middleware = [
        Authentication::class,
        RouteMiddleware::class,
    ];

    public function __construct(private ContainerInterface $container)
    {
    }

    public function handle(Request $request): Response
    {
        if (empty($this->middleware)) {
            return new Response('Server error', 500);
        }

        /** @var MiddlewareInterface $middlewareClass */
        $middlewareClass = array_shift($this->middleware);

        $middleware = $this->container->get($middlewareClass);

        return $middleware->process($request, $this);
    }
}
