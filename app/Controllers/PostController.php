<?php

namespace App\Controllers;

use App\Entities\Post;
use App\Services\DbService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Sergei\PhpFramework\Controller\AbstractController;
use Sergei\PhpFramework\Http\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PostController extends AbstractController
{
    public function __construct(private DbService $service)
    {
    }

    /**
     * @throws SyntaxError
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(int $id): Response
    {
        $post = $this->service->find($id);

        return $this->render('post.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws SyntaxError
     * @throws ContainerExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function create(): Response
    {
        return $this->render('create.html.twig');
    }

    public function store()
    {
        $post = (new \App\Entities\Post)->create($this->request->getPost()['title'], $this->request->getPost()['body']);
        $post = $this->service->save($post);
        dd($post);
    }
}
