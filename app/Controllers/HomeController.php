<?php

namespace App\Controllers;

use App\Services\TestServices;
use Sergei\PhpFramework\Controller\AbstractController;
use Sergei\PhpFramework\Http\Response;
use Twig\Environment;

class HomeController extends AbstractController
{
    public function __construct(private readonly TestServices $services)
    {
    }

    public function index(): Response
    {
        dd($this->container->get('twig'));
        $content = '<h1>HELLO!!!</h1>';
        $content .= $this->services->getString();

        return new Response($content);
    }
}
