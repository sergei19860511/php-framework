<?php

namespace Sergei\PhpFramework\Container;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
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
     * @throws \ReflectionException
     */
    public function get(string $id)
    {
        if (! $this->has($id)) {
            if (! class_exists($id)) {
                throw new ContainerException("Service $id not found");
            }

            $this->add($id);
        }

        return $this->resolve($this->service[$id]);
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
        $classDependencies = $this->resolveClassDependencies($constructParams);

        //6 Создать объект с зависимостями
        //7 Вернуть объект
        return $reflection->newInstanceArgs($classDependencies);
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->service);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \ReflectionException
     */
    private function resolveClassDependencies(array $constructParams): array
    {
        //1 Инициализировать пустой список зависимостей
        $classDependencies = [];

        //2 Найти и cоздать экземпляр
        /** @var  $constructParam \ReflectionParameter */
        foreach ($constructParams as $constructParam) {
            // Получить тип параметра
            $serviceType = $constructParam->getType();

            // Создать экземпляр используя $serviceType
            $service = $this->get($serviceType->getName());

            // Добавить сервис в class $classDependencies
            $classDependencies[] = $service;
        }

        //3 Вернуть массив $classDependencies
        return $classDependencies;
    }
}
