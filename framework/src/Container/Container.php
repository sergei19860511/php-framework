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
     * @throws \ReflectionException
     */
    private function resolve($class)
    {
        //1 Создать объект Reflection
        $reflection = new \ReflectionClass($class);

        //2 Использовать Reflection для попытки получить конструктор класса
        $construct = $reflection->getConstructor();

        //3 Если нет конструктора просто создать экземпляр
        if (is_null($construct)) {
            return $reflection->newInstance();
        }

        //4 Получить параметры конструктора
        $constructParams = $construct->getParameters();

        //5 Получить зависимости
        $classDependecys = $this->resolveClassDependencys($constructParams);

        //6 Создать объект с зависимостями

        //7 Вернуть объект
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->service);
    }
}
