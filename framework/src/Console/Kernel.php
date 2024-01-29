<?php

namespace Sergei\PhpFramework\Console;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Kernel
{
    public function __construct(private ContainerInterface $container, private Application $app)
    {
    }

    /**
     * @throws \ReflectionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(): int
    {
        $this->registerCommands();

        $status = $this->app->run();

        return $status;
    }

    /**
     * @throws \ReflectionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function registerCommands(): void
    {
        $commandClasses = new \DirectoryIterator(__DIR__.'/Commands');
        $namespace = $this->container->get('command-namespace');

        /** @var \DirectoryIterator $commandClass */
        foreach ($commandClasses as $commandClass) {
            if (! $commandClass->isFile()) {
                continue;
            }

            $command = $namespace.pathinfo($commandClass, PATHINFO_FILENAME);

            if (is_subclass_of($command, CommandInterface::class)) {
                $commandName = (new \ReflectionClass($command))->getProperty('name')->getDefaultValue();

                $this->container->add("console:$commandName", $command);
            }

        }
    }
}
