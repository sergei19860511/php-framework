<?php

namespace App\Entities;

interface EntitiesInterface
{
    public static function create(string $title, string $text, ?int $id = null, ?\DateTimeImmutable $created_at = null): static;
}
