<?php

namespace Sergei\PhpFramework\Http;

readonly class Request
{
    public function __construct(
        private array $get,
        private array $post,
        private array $cookie,
        private array $files,
        private array $server,
    ) {
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function getParams(): array
    {
        return $this->get;
    }

    public function getUri(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }
}
