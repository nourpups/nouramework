<?php

namespace Nouracea\Nouramework\Console;

use Nouracea\Nouramework\Exceptions\Console\ConsoleException;
use Psr\Container\ContainerInterface;

class Application
{
    public function __construct(
        private ContainerInterface $container
    ) {}

    public function run(): int
    {
        $argv = $_SERVER['argv'];
        $commandName = $argv[1] ?? null;

        if (! $commandName) {
            throw new ConsoleException('Invalid console command');
        }

        /** @var CommandInterface $command */
        $command = $this->container->get("console:$commandName");

        $args = array_slice($argv, 2);
        $options = $this->parseOptions($args);

        $status = $command->execute($options);

        return $status;
    }

    private function parseOptions(array $args): array
    {
        $options = [];

        foreach ($args as $arg) {
            if (str_starts_with($arg, '--')) {
                [$optionName, $optionValue] = explode('=', substr($arg, 2));
                $options[$optionName] = $optionValue ?? true;
            }
        }

        return $options;
    }
}
