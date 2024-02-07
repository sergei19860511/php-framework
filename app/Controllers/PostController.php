<?php

namespace App\Controllers;

use App\Entities\Post;
use App\Services\DbService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Sergei\PhpFramework\Controller\AbstractController;
use Sergei\PhpFramework\Http\Exceptions\NotFoundException;
use Sergei\PhpFramework\Http\RedirectResponse;
use Sergei\PhpFramework\Http\Response;
use Sergei\PhpFramework\Session\SessionInterface;
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
     * @throws NotFoundException
     */
    public function index(int $id): Response
    {
        $post = $this->service->findOrFail($id);

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

    public function store(): RedirectResponse
    {
        if (empty($this->request->getPost()['title']) || empty($this->request->getPost()['body'])) {
            $this->request->getSession()->setFlash('error', 'Необходимо заполнить обязательные поля');

            return new RedirectResponse('/post/create');
        }

        $post = Post::create($this->request->getPost()['title'], $this->request->getPost()['body']);
        $post = $this->service->save($post);
        $this->request->getSession()->setFlash('success', 'Успешно');

        return new RedirectResponse("/posts/{$post->getId()}");
    }
}
