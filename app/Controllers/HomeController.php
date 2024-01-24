<?php

namespace App\Controllers;

use App\Services\TestServices;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Sergei\PhpFramework\Controller\AbstractController;
use Sergei\PhpFramework\Http\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HomeController extends AbstractController
{
    public function __construct(private readonly TestServices $services)
    {
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws SyntaxError
     * @throws ContainerExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(): Response
    {
        return $this->render('home.html.twig', [
            'test' => $this->services->getString(),
        ]);
    }
}
