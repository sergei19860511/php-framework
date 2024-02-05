<?php

namespace Sergei\PhpFramework\Controller;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Sergei\PhpFramework\Http\Request;
use Sergei\PhpFramework\Http\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class AbstractController
{
    protected ?ContainerInterface $container = null;

    protected Request $request;

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    /**
     * @throws SyntaxError
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function render(string $view, array $params = [], ?Response $response = null): Response
    {
        /** @var $twig Environment */
        $twig = $this->container->get('twig');

        $content = $twig->render($view, $params);

        $response ??= new Response();
        $response->setContent($content);

        return $response;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }
}
