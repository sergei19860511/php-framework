<?php

namespace Sergei\PhpFramework\Console\Commands;

use Sergei\PhpFramework\Console\CommandInterface;

class MigrateCommand implements CommandInterface
{
    private string $name = 'migrate';

    public function execute(array $params = []): int
    {
        echo "HELLO {$params['name']}";

        return 0;
    }
}
