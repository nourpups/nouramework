<?php

use Doctrine\DBAL\Connection;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Nouracea\Nouramework\Dbal\ConnectionFactory;
use Nouracea\Nouramework\Http\Controller\AbstractController;
use Nouracea\Nouramework\Http\Kernel;
use Nouracea\Nouramework\Routing\Router;
use Nouracea\Nouramework\Routing\RouterInterface;
use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$dotenv = new Dotenv();
$dotenv->load(BASE_PATH.'/.env');

$container = new Container();
$container->delegate(new ReflectionContainer(true));

$container->addShared(RouterInterface::class, Router::class);

$routes = require BASE_PATH.'/routes/web.php';
$container->extend(RouterInterface::class)
    ->addMethodCall('registerRoutes', [new ArrayArgument($routes)]);

$container->addShared(Kernel::class)
    ->addArgument(RouterInterface::class)
    ->addArgument($container);

$viewsPath = BASE_PATH.'/views';
$container->addShared('twig-loader', FilesystemLoader::class)
    ->addArgument(new StringArgument($viewsPath));

$container->addShared('twig', Environment::class)
    ->addArgument('twig-loader');

$container->inflector(AbstractController::class)
    ->invokeMethod('setContainer', [$container]);

$databaseUrl = 'pdo-mysql://lemp:lemp@database:3306/lemp?charset=utf8mb4';
$container->add(ConnectionFactory::class)
    ->addArgument(new StringArgument($databaseUrl));

$container->addShared(Connection::class, function () use ($container) {
    return $container->get(ConnectionFactory::class)->create();
});

return $container;
