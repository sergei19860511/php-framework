<?php

namespace Sergei\PhpFramework\Http;

use League\Container\Container;
use Sergei\PhpFramework\Http\Exceptions\HttpException;
use Sergei\PhpFramework\Http\Middleware\RequestHandlerInterface;
use Sergei\PhpFramework\Routing\RouterInterface;

class Kernel
{
    private string $appEnv;

    public function __construct(
        private RouterInterface $router,
        private readonly Container $container,
        private RequestHandlerInterface $requestHandler
    ) {
        $this->appEnv = $this->container->get('APP_ENV');
    }

    public function handle(Request $request): Response
    {
        try {
            $response = $this->requestHandler->handle($request);
        } catch (\Exception $e) {
            $response = $this->createExceptionResponse($e);
        }

        return $response;
    }

    public function clear(Request $request, Response $response): void
    {
        $request->getSession()->clearFlash();
    }

    private function createExceptionResponse(\Exception $e): Response
    {
        if (in_array($this->appEnv, ['local', 'dev'])) {
            throw $e;
        }

        if ($e instanceof HttpException) {
            return new Response($e->getMessage(), $e->getStatusCode());
        }

        return new Response('Server error', 500);
    }
}
