<?php

namespace Nouracea\Nouramework\Routing;

use League\Container\Container;
use Nouracea\Nouramework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request, Container $container): array;

    public function registerRoutes(array $routes): void;
}
