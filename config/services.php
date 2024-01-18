<?php

use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Sergei\PhpFramework\Controller\AbstractController;
use Sergei\PhpFramework\Helpers\Helpers;
use Sergei\PhpFramework\Http\Kernel;
use Sergei\PhpFramework\Routing\Router;
use Sergei\PhpFramework\Routing\RouterInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$appEnv = Helpers::get_env('APP_ENV');

$routes = include BASE_PATH.'/routes/web.php';

$container = new Container();

$container->delegate(new ReflectionContainer(true));

$container->add('APP_ENV', new StringArgument($appEnv));

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)->addMethodCall('registerRoute', [new ArrayArgument($routes)]);

$container->add(Kernel::class)->addArgument(RouterInterface::class)->addArgument($container);

$container->addShared('twig-loader', FilesystemLoader::class)->addArgument(new StringArgument(BASE_PATH.'/views'));

$container->addShared('twig', Environment::class)->addArgument('twig-loader');

$container->inflector(AbstractController::class)->invokeMethod('setContainer', [$container]);

return $container;
