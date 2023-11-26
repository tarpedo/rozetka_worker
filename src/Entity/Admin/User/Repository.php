<?php

declare(strict_types=1);

namespace App\Entity\Admin\User;

use App\Entity\Admin\User;
use App\Entity\Admin\UserRole;
use App\Repository\Admin\UserInterface;

class Repository implements UserInterface
{
    private \Doctrine\ORM\EntityRepository $repository;

    public function __construct(
        private readonly \Doctrine\ORM\EntityManagerInterface $em,
    ) {
        $this->repository = $this->em->getRepository(User::class);
    }

    /**
     * @param UserRole[] $roles
     */
    public function create(string $login, array $roles): User
    {
        $user = new User();
        $user->setLogin($login);

        foreach ($roles as $role) {
            $user->addRole($role);
        }

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function findByLogin(string $login): ?User
    {
        return $this->repository->findOneBy([
            'login' => $login,
        ]);
    }
}