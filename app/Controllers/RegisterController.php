<?php

namespace App\Controllers;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Sergei\PhpFramework\Controller\AbstractController;
use Sergei\PhpFramework\Http\Request;
use Sergei\PhpFramework\Http\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class RegisterController extends AbstractController
{
    /**
     * @throws NotFoundExceptionInterface
     * @throws SyntaxError
     * @throws ContainerExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function createForm(): Response
    {
        return $this->render('register.html.twig');
    }

    public function store()
    {
        dd($this->request);
    }
}