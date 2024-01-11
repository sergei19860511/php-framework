<?php

namespace App\Controllers;

use Sergei\PhpFramework\Http\Response;

class HomeController
{
    public function index(): Response
    {
        $content = '<h1>HELLO!!!</h1>';

        return new Response($content);
    }
}