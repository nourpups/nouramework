<?php

namespace Nouracea\Nouramework\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use League\Container\Container;
use Nouracea\Nouramework\Exceptions\Http\MethodNotAllowedException;
use Nouracea\Nouramework\Exceptions\Http\NotFoundException;
use Nouracea\Nouramework\Http\Request;

use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    private array $routes;

    public function dispatch(Request $request, Container $container): array
    {
        [$handler, $queryParams] = $this->extractRouteInfo($request);

        if (is_array($handler)) {
            [$controllerId, $method] = $handler;
            $controller = $container->get($controllerId);
            $handler = [$controller, $method];
        }

        return [$handler, $queryParams];
    }

    private function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            foreach ($this->routes as $route) {
                $collector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPath(),
        );

        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = implode(', ', $routeInfo[1]);

                throw new MethodNotAllowedException("Allowed HTTP methods: $allowedMethods", 405);
            case Dispatcher::NOT_FOUND:
                throw new NotFoundException('Page not found', 404);
        }
    }

    public function registerRoutes(array $routes): void
    {
        $this->routes = $routes;
    }
}
