<?php

namespace Sergei\PhpFramework\Http;

use Sergei\PhpFramework\Session\SessionInterface;

readonly class Request
{
    private SessionInterface $session;

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

    public function getPost(): array
    {
        return $this->post;
    }

    public function getSession(): SessionInterface
    {
        return $this->session;
    }

    public function setSession(SessionInterface $session): void
    {
        $this->session = $session;
    }

    public function input(string $key, string $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }
}
