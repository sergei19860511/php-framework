<?php

namespace Sergei\PhpFramework\Http\Middleware;

use Sergei\PhpFramework\Http\Request;
use Sergei\PhpFramework\Http\Response;

class Success implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        return new Response('Success');
    }
}
