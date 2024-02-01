<?php

namespace App\Entities;

class Post
{
    public function __construct(private ?int $id, private string $title, private string $text, ?\DateTimeImmutable $created_at)
    {
    }

    public static function create(string $title, string $text, ?int $id = null, ?\DateTimeImmutable $created_at = null): static
    {
        return new static($id, $title, $text, $created_at);
    }
}
