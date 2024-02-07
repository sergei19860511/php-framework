<?php

namespace Sergei\PhpFramework\Http\Middleware;

use Sergei\PhpFramework\Http\Middleware\MiddlewareInterface;
use Sergei\PhpFramework\Http\Request;
use Sergei\PhpFramework\Http\Response;
use Sergei\PhpFramework\Session\SessionInterface;

class SessionMiddleware implements MiddlewareInterface
{
    public function __construct(private SessionInterface $session)
    {
    }

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        $this->session->start();
        $request->setSession($this->session);
        return $handler->handle($request);
    }
}