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

class PostController extends AbstractController
{
    /**
     * @throws SyntaxError
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(int $id): Response
    {
        return $this->render('post.html.twig', [
            'post' => $id,
        ]);
    }

    public function create(): Response
    {
        return $this->render('create.html.twig');
    }

    public function store()
    {
        dd($this->request->getPost());
    }
}
