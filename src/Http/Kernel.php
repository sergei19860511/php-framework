<?php

namespace Sergei\PhpFramework\Http;

class Kernel
{
    public function handle(Request $request): Response
    {
        $content = "<h1>HELLO {$request->getParams()['name']}</h1>";

        return new Response($content, 200, []);
    }
}