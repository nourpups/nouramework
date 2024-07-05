<?php

namespace Nouracea\Nouramework\Console\Commands;

use Nouracea\Nouramework\Console\CommandInterface;

class MigrateCommand implements CommandInterface
{
    private string $name = 'migrate';

    public function execute(array $parameters = []): int
    {
        return 0;
    }
}
