<?php

declare(strict_types=1);

namespace App\Repository\Admin;

use App\Entity\Admin\User;
use App\Entity\Admin\UserRole;

interface UserInterface
{
    /**
     * @param UserRole[] $roles
     */
    public function create(string $login, array $roles): User;

    public function findByLogin(string $login): ?User;
}