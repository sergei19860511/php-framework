<?php

namespace App\Entities;

class User
{
    public function __construct(
        private ?int $id,
        private string $name,
        private string $email,
        private string $password,
        private ?\DateTimeImmutable $created_at)
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): void
    {
        $this->created_at = $created_at;
    }

    public static function create(
        string $name,
        string $email,
        string $password,
        ?int $id = null,
        ?\DateTimeImmutable $created_at = null
    ): static {
        return new static($id, $name, $email, $password, $created_at ?? new \DateTimeImmutable('Europe/Moscow'));
    }
}
