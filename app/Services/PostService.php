<?php

namespace App\Services;

use App\Entities\Post;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Sergei\PhpFramework\Http\Exceptions\NotFoundException;

class PostService
{
    private QueryBuilder $query;

    public function __construct(private Connection $connection)
    {
        $this->query = $this->connection->createQueryBuilder();
    }

    public function save(Post $post): Post
    {
        $this->query->insert('posts')
            ->values([
                'title' => ':title',
                'text' => ':text',
                'created_at' => ':created_at',
            ])
            ->setParameters([
                'title' => $post->getTitle(),
                'text' => $post->getText(),
                'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
            ])->executeQuery();
        $postId = $this->connection->lastInsertId();
        $post->setId($postId);

        return $post;
    }

    public function find(int $id): ?Post
    {
        $result = $this->query->select('*')
            ->from('posts')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->executeQuery()
            ->fetchAssociative();

        if (! $result) {
            return null;
        }

        return Post::create(
            title: $result['title'],
            text: $result['text'],
            id: $result['id'],
            created_at: new \DateTimeImmutable($result['created_at'])
        );
    }

    public function findOrFail(int $id): Post
    {
        $post = $this->find($id);

        if (is_null($post)) {
            throw new NotFoundException("Post - $id not found");
        }

        return $post;
    }
}
