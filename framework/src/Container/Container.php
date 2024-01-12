<?php

namespace Sergei\PhpFramework\Container;

use Psr\Container\ContainerInterface;
use Sergei\PhpFramework\Container\Exceptions\ContainerException;

class Container implements ContainerInterface
{
    private array $service = [];

    /**
     * @throws ContainerException
     */
    public function add(string $id, string|object|null $concrete = null): void
    {
        if (is_null($concrete)) {
            $concrete = $id;

            if (! class_exists($id)) {
                throw new ContainerException("Service $id not found");
            }
        }

        $this->service[$id] = $concrete;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $id)
    {
        return new $this->service[$id];
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->service);
    }
}
