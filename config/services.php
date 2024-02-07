<?php

use Doctrine\DBAL\Connection;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Sergei\PhpFramework\Console\Application;
use Sergei\PhpFramework\Console\Commands\MigrateCommand;
use Sergei\PhpFramework\Console\Kernel as ConsoleKernel;
use Sergei\PhpFramework\Controller\AbstractController;
use Sergei\PhpFramework\Dbal\ConnectionFactory;
use Sergei\PhpFramework\Helpers\Helpers;
use Sergei\PhpFramework\Http\Kernel;
use Sergei\PhpFramework\Http\Middleware\RequestHandler;
use Sergei\PhpFramework\Http\Middleware\RequestHandlerInterface;
use Sergei\PhpFramework\Routing\Router;
use Sergei\PhpFramework\Routing\RouterInterface;
use Sergei\PhpFramework\Session\Session;
use Sergei\PhpFramework\Session\SessionInterface;
use Sergei\PhpFramework\Template\TwigFactory;

$appEnv = Helpers::loadEnv('APP_ENV');
$dataBase = Helpers::loadEnv('DATA_BASE');

$routes = include BASE_PATH.'/routes/web.php';

$container = new Container();

$container->delegate(new ReflectionContainer(true));

$container->add('command-namespace', new StringArgument('Sergei\\PhpFramework\\Console\\Commands\\'));

$container->add('APP_ENV', new StringArgument($appEnv));

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)->addMethodCall('registerRoute', [new ArrayArgument($routes)]);

$container->add(RequestHandlerInterface::class, RequestHandler::class);

$container->add(Kernel::class)
    ->addArguments([
        RouterInterface::class,
        $container,
        RequestHandlerInterface::class
    ]);

$container->addShared(SessionInterface::class, Session::class);

$container->add('twig-factory', TwigFactory::class)
    ->addArguments([new StringArgument(BASE_PATH.'/views'), SessionInterface::class]);

$container->addShared('twig', function () use ($container) {
    return $container->get('twig-factory')->create();
});

$container->inflector(AbstractController::class)->invokeMethod('setContainer', [$container]);

$container->add(ConnectionFactory::class)->addArgument(new StringArgument($dataBase));

$container->addShared(Connection::class, function () use ($container): Connection {
    return $container->get(ConnectionFactory::class)->create();
});

$container->add('console:migrate', MigrateCommand::class)
    ->addArgument(Connection::class)
    ->addArgument(new StringArgument(BASE_PATH.'/database/migrations'));

$container->add(Application::class)->addArgument($container);

$container->add(ConsoleKernel::class)->addArgument($container)->addArgument(Application::class);

return $container;
