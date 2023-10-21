<?php

declare(strict_types=1);

namespace App\Repository\Rozetka;

interface AccountInterface
{
    public function create(\App\Entity\Rozetka\Account $account): void;
    public function saveAll(): void;

    public function findByUsername(string $username): ?\App\Entity\Rozetka\Account;
}