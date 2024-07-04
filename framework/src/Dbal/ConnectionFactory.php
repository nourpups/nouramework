<?php

namespace Nouracea\Nouramework\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;

class ConnectionFactory
{
    public function __construct(
        private readonly string $databaseUrl
    ) {}

    public function create(): Connection
    {
        $urlParser = new DsnParser();
        $connectionParams = $urlParser->parse($this->databaseUrl);

        return DriverManager::getConnection($connectionParams);
    }
}
