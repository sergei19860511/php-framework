<?php

namespace Sergei\PhpFramework\Console\Commands;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Sergei\PhpFramework\Console\CommandInterface;

class MigrateCommand implements CommandInterface
{
    private const MIGRATION_TABLE_NAME = 'migrations';
    public function __construct(private Connection $connection)
    {
    }

    private string $name = 'migrate';

    public function execute(array $params = []): int
    {
        $this->addTableMigrations();

        return 0;
    }

    private function addTableMigrations(): void
    {
        $schemaManager = $this->connection->createSchemaManager();
        if (! $schemaManager->tablesExist(self::MIGRATION_TABLE_NAME)) {
            $schema = new Schema();
            $table = $schema->createTable(self::MIGRATION_TABLE_NAME);
            $table->addColumn('id', Types::INTEGER, [
                'autoincrement' => true,
                'unsigned' => true
            ]);
            $table->addColumn('migrate', Types::STRING);
            $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, [
                'default' => 'CURRENT_TIMESTAMP'
            ]);
            $table->setPrimaryKey(['id']);

            $sql = $schema->toSql($this->connection->getDatabasePlatform());
            $this->connection->executeQuery($sql[0]);
        }
    }
}
