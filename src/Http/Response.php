<?php

namespace Sergei\PhpFramework\Http;

class Response
{
    public function __construct(private mixed $content, private int $statusCode, private array $headers)
    {
    }

    public function send(): void
    {
        echo $this->content;
    }
}