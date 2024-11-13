<?php

namespace Sergei\PhpFramework\Http\Middleware;

use Sergei\PhpFramework\Http\Request;
use Sergei\PhpFramework\Http\Response;

class Authentication implements MiddlewareInterface
{
    private bool $authenticate = true;

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        if (! $this->authenticate) {
            return new Response('Authenticated failed', 401);
        }

        return $handler->handle($request);
    }
}
