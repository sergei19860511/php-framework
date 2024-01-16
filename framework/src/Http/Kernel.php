<?php

namespace Sergei\PhpFramework\Http;

use League\Container\Container;
use Sergei\PhpFramework\Http\Exceptions\HttpException;
use Sergei\PhpFramework\Routing\RouterInterface;

class Kernel
{
    public function __construct(private RouterInterface $router, private readonly Container $container)
    {
    }

    public function handle(Request $request): Response
    {
        try {
            [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);

            $response = call_user_func_array($routeHandler, $vars);
        } catch (HttpException $exception) {
            $response = new Response($exception->getMessage(), $exception->getStatusCode());
        } catch (\Throwable $exception) {
            $response = new Response($exception->getMessage(), 500);
        }

        return $response;
    }
}
