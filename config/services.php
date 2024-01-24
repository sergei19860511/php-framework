<?php

use Doctrine\DBAL\Connection;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Sergei\PhpFramework\Console\Kernel as ConsoleKernel;
use Sergei\PhpFramework\Controller\AbstractController;
use Sergei\PhpFramework\Dbal\ConnectionFactory;
use Sergei\PhpFramework\Helpers\Helpers;
use Sergei\PhpFramework\Http\Kernel;
use Sergei\PhpFramework\Routing\Router;
use Sergei\PhpFramework\Routing\RouterInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$appEnv = Helpers::loadEnv('APP_ENV');
$dataBase = Helpers::loadEnv('DATA_BASE');

$routes = include BASE_PATH.'/routes/web.php';

$container = new Container();

$container->delegate(new ReflectionContainer(true));

$container->add('command-namespace', new StringArgument('Sergei\\PhpFramework\\Console\\Commands\\'));

$container->add('APP_ENV', new StringArgument($appEnv));

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)->addMethodCall('registerRoute', [new ArrayArgument($routes)]);

$container->add(Kernel::class)->addArgument(RouterInterface::class)->addArgument($container);

$container->addShared('twig-loader', FilesystemLoader::class)->addArgument(new StringArgument(BASE_PATH.'/views'));

$container->addShared('twig', Environment::class)->addArgument('twig-loader');

$container->inflector(AbstractController::class)->invokeMethod('setContainer', [$container]);

$container->add(ConnectionFactory::class)->addArgument(new StringArgument($dataBase));

$container->addShared(Connection::class, function () use ($container): Connection {
    return $container->get(ConnectionFactory::class)->create();
});

$container->add(ConsoleKernel::class)->addArgument($container);

return $container;
