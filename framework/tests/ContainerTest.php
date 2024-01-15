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

    /**
     * @throws ContainerException
     */
    public function test_method_has()
    {
        $container = new Container();

        $container->add('somecode-class', SomecodeClass::class);

        $this->assertTrue($container->has('somecode-class'));

        $this->assertFalse($container->has('no-class'));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ContainerException
     */
    public function test_dependencys()
    {
        $container = new Container();

        $container->add('somecode-class', SomecodeClass::class);

        /** @var  $somecode SomecodeClass */
        $somecode = $container->get('somecode-class');

        $this->assertInstanceOf(TestDependecys::class, $somecode->getDepen());

    }

}
