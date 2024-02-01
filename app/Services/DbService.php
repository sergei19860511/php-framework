<?php

namespace App\Services;

use App\Entities\EntitiesInterface;
use Doctrine\DBAL\Connection;

class DbService
{
    public function __construct(private Connection $connection)
    {
    }

    public function save(EntitiesInterface $entities): EntitiesInterface
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->insert('posts')
            ->values([
                'title' => ':title',
                'text' => ':text',
                'created_at' => ':created_at',
            ])
            ->setParameters([
                'title' => $entities->getTitle(),
                'text' => $entities->getText(),
                'created_at' => $entities->getCreatedAt()->format('Y-m-d H:i:s'),
            ])->executeQuery();
        $postId = $this->connection->lastInsertId();
        $entities->setId($postId);

        return $entities;
    }
}