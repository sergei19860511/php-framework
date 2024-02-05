<?php

namespace App\Entities;

class Post implements EntitiesInterface
{
    public function __construct(
        private ?int $id,
        private string $title,
        private string $text,
        private ?\DateTimeImmutable $created_at)
    {
    }

    public static function create(string $title, string $text, ?int $id = null, ?\DateTimeImmutable $created_at = null): static
    {
        return new static($id, $title, $text, $created_at ?? new \DateTimeImmutable('Europe/Moscow'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): void
    {
        $this->created_at = $created_at;
    }
}
