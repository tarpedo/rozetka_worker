<?php

declare(strict_types=1);

namespace App\Rozetka\Account;

interface RepositoryInterface
{
    public function create(\App\Rozetka\Account $account): void;
    public function saveAll(): void;

    public function findByUsername(string $username): ?\App\Rozetka\Account;
}