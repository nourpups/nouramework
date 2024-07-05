<?php

namespace Nouracea\Nouramework\Console;

interface CommandInterface
{
    public function execute(array $parameters = []): int;
}
