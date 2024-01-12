<?php

namespace Sergei\PhpFramework\Container;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{

    private array $service = [];

    public function add(string $id, string|object $concrete = null): void
    {
        $this->service[$id] = $concrete;
    }

    /**
     * @inheritDoc
     */
    public function get(string $id)
    {
        return new $this->service[$id];
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
    }
}