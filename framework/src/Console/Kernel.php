<?php

namespace Nouracea\Nouramework\Console;

use DirectoryIterator;
use Psr\Container\ContainerInterface;

class Kernel
{
    public function __construct(
        private readonly ContainerInterface $container,
        private readonly Application $app,
    ) {}

    public function handle(): int
    {
        $this->registerCommands();

        $status = $this->app->run();

        return $status;
    }

    public function registerCommands()
    {
        $commandFiles = new DirectoryIterator(__DIR__.'/Commands');
        $baseNamespace = $this->container->get('framework-commands-namespace');

        /** @var DirectoryIterator $commandFile */
        foreach ($commandFiles as $commandFile) {
            if (! $commandFile->isFile()) {
                continue;
            }

            $command = $baseNamespace.pathinfo($commandFile, PATHINFO_FILENAME);

            if (is_subclass_of($command, CommandInterface::class)) {
                $commandName = (new \ReflectionClass($command))
                    ->getProperty('name')
                    ->getDefaultValue();
                $this->container->add("console:$commandName", $command);
            }
        }
    }
}
