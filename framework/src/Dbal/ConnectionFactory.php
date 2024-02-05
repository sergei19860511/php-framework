<?php

namespace Sergei\PhpFramework\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;

class ConnectionFactory
{
    public function __construct(private readonly string $dbUrl)
    {
    }

    /**
     * @throws Exception
     */
    public function create(): Connection
    {
        return DriverManager::getConnection([
            'url' => $this->dbUrl,
        ]);
    }
}
