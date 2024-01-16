<?php

namespace App\Controllers;

use Sergei\PhpFramework\Http\Response;

class PostController
{
    public function index(int $id): Response
    {
        $content = "<h1>The Post: $id</h1>";

        return new Response($content);
    }
}
