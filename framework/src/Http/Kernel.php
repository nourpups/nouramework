<?php

namespace Nouracea\Nouramework\Http;

use League\Container\Container;
use Nouracea\Nouramework\Exceptions\Http\HttpException;
use Nouracea\Nouramework\Routing\RouterInterface;

class Kernel
{
    public function __construct(
        private readonly RouterInterface $router,
        private readonly Container $container
    ) {}

    public function handle(Request $request): Response
    {
        try {
            [$handler, $queryParams] = $this->router->dispatch($request, $this->container);

            $response = call_user_func_array($handler, $queryParams);
        } catch (\Exception $e) {
            $response = $this->createExceptionResponse($e);
        }

        return $response;
    }

    public function createExceptionResponse(\Exception $e): Response
    {
        if (in_array($_ENV['APP_ENV'], ['local', 'testing'])) {
            throw $e;
        }

        if ($e instanceof HttpException) {
            return new Response($e->getMessage(), $e->getCode());
        }

        return new Response('Internal Server Error', 500);
    }
}
