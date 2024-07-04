<?php

namespace Nouracea\Nouramework\Http\Controller;

use Nouracea\Nouramework\Http\Response;
use Psr\Container\ContainerInterface;
use Twig\Environment;

abstract class AbstractController
{
    protected ?ContainerInterface $container = null;

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function render(
        string $view,
        array $parameters = [],
        ?Response $response = null
    ) {
        /** @var Environment $twig */
        $content = $this->container->get('twig')
            ->render($view.'.twig', $parameters);

        $response ??= new Response();
        $response->setContent($content);

        return $response;
    }
}
