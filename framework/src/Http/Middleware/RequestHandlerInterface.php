<?php

namespace Sergei\PhpFramework\Http\Middleware;

use Sergei\PhpFramework\Http\Request;
use Sergei\PhpFramework\Http\Response;

interface RequestHandlerInterface
{
    public function handle(Request $request): Response;
}
