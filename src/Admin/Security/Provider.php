<?php

namespace App\Admin\Security;

use App\Entity\Admin\User;
use App\Entity\Admin\User\Repository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class Provider implements UserProviderInterface
{
    public function __construct(
        private readonly Repository $userRepository,
    ) {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->createUser($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return $class === User::class
            || is_subclass_of($class, User::class);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return $this->createUser($identifier);
    }

    private function createUser(string $email): User
    {
        $user = $this->userRepository->findByLogin($email);
        if ($user === null) {
            throw new \Symfony\Component\Security\Core\Exception\UserNotFoundException();
        }

        return $user;
    }
}