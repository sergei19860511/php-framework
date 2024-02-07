<?php

namespace Sergei\PhpFramework\Http\Middleware;

use Sergei\PhpFramework\Http\Request;
use Sergei\PhpFramework\Http\Response;

class RequestHandler implements RequestHandlerInterface
{
    private array $middleware = [
        Authentication::class,
        Success::class,
    ];

    public function handle(Request $request): Response
    {
        if (empty($this->middleware)) {
            return new Response('Server error', 500);
        }

        /** @var MiddlewareInterface $middlewareClass */
        $middlewareClass = array_shift($this->middleware);

        return (new $middlewareClass())->process($request, $this);
    }
}
