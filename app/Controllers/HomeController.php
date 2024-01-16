<?php

namespace App\Controllers;

use App\Services\TestServices;
use Sergei\PhpFramework\Http\Response;

class HomeController
{
    public function __construct(private readonly TestServices $services)
    {
    }

    public function index(): Response
    {
        $content = '<h1>HELLO!!!</h1>';
        $content .= $this->services->getString();

        return new Response($content);
    }
}
