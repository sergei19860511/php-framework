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
        if (! $this->has($id)) {
            if (! class_exists($id)) {
                throw new ContainerException("Service $id not found");
            }

            $this->add($id);
        }

        $instance = $this->resolve($this->service[$id]);

        return $instance;
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->service);
    }
}
