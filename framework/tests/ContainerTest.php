<?php

namespace Sergei\PhpFramework\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Sergei\PhpFramework\Container\Container;
use Sergei\PhpFramework\Container\Exceptions\ContainerException;

class ContainerTest extends TestCase
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ContainerException
     */
    public function test_getting_service_from_container()
    {
        $container = new Container();

        $container->add('somecode-class', SomecodeClass::class);

        $this->assertInstanceOf(SomecodeClass::class, $container->get('somecode-class'));
    }

    /**
     * @throws ContainerException
     */
    public function test_container_exception()
    {
        $container = new Container();

        $this->expectException(ContainerException::class);

        $container->add('no-class');
    }
}
