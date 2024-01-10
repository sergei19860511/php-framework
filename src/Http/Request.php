<?php

namespace Sergei\PhpFramework\Http;

readonly class Request
{
    public function __construct(
        private array $get,
        private array $post,
        private array $cookie,
        private array $files,
        public array $server,
    )
    {
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function getParams(): array
    {
        return $this->get;
    }
}