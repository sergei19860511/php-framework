<?php

namespace Sergei\PhpFramework\Console;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Application
{
    public function __construct(private ContainerInterface $container)
    {
    }

    /**
     * @throws ConsoleException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(): int
    {
        $argv = $_SERVER['argv'];
        $commandName = $argv[1] ?? null;

        if (! $commandName) {
            throw new ConsoleException("Command {$commandName} not found");
        }
        /** @var CommandInterface $command */
        $command = $this->container->get("console:$commandName");
        $args = array_slice($argv, 2);
        $options = $this->parseArgs($args);

        echo "Success {$commandName}".PHP_EOL;

        return $command->execute($options);
    }

    private function parseArgs(array $args): array
    {
        $options = [];
        foreach ($args as $arg) {
            if (str_starts_with($arg, '--')) {
                $option = explode('=', substr($arg, 2));
                $options[$option[0]] = $option[1] ?? true;
            }
        }

        return $options;
    }
}
