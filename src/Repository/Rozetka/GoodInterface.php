<?php

declare(strict_types=1);

namespace App\Repository\Rozetka;

interface GoodInterface
{
    public function create(\App\Entity\Rozetka\Good $account): void;

    public function saveAll(): void;

    public function findByRzItemId(int $rzItemId): ?\App\Entity\Rozetka\Good;
}