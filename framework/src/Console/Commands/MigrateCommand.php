<?php

namespace Sergei\PhpFramework\Console\Commands;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Sergei\PhpFramework\Console\CommandInterface;

class MigrateCommand implements CommandInterface
{
    private const MIGRATION_TABLE_NAME = 'migrations';
    public function __construct(private Connection $connection, private string $migratePath)
    {
    }

    private string $name = 'migrate';

    public function execute(array $params = []): int
    {
        try {
            $this->addTableMigrations();
            $this->connection->beginTransaction();
            $appliedMigrations = $this->getAppliedMigrations();
            $migrationFiles = $this->getMigrationsFiles();
            $migrateToApply = array_values(array_diff($migrationFiles, $appliedMigrations));

            $schema = new Schema();
            foreach ($migrateToApply as $migrate) {
                $migrationInstance = require $this->migratePath."/$migrate";
                $migrationInstance->up($schema);
                $this->addMigrateToTableMigrations($migrate);
            }


            $this->connection->commit();
        }catch (\Throwable $e) {
            $this->connection->rollBack();
            throw $e;
        }

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

    private function getAppliedMigrations(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        return $queryBuilder->select('migrate')
            ->from(self::MIGRATION_TABLE_NAME)
            ->executeQuery()
            ->fetchFirstColumn();
    }

    private function getMigrationsFiles(): array
    {
        $migrationsFiles = scandir($this->migratePath);
        $filtered = array_filter($migrationsFiles, function ($fileName) {
           return ! in_array($fileName, ['.', '..']);
        });

        return array_values($filtered);
    }

    private function addMigrateToTableMigrations(string $nameMigrate): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->insert(self::MIGRATION_TABLE_NAME)
            ->values(['migrate' => ':migrate'])
            ->setParameter('migrate', $nameMigrate)
            ->executeQuery();
    }
}
