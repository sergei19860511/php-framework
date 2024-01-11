<?php

namespace Sergei\PhpFramework\Routing;

use Sergei\PhpFramework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request);
}