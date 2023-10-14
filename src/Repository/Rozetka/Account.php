<?php

declare(strict_types=1);

namespace App\Repository\Rozetka;

use App\Rozetka\Account\RepositoryInterface;

class Account implements RepositoryInterface
{
    private \Doctrine\ORM\EntityRepository $repository;

    public function __construct(
        private readonly \Doctrine\ORM\EntityManagerInterface $em,
    ) {
        $this->repository = $this->em->getRepository(\App\Rozetka\Account::class);
    }

    public function create(\App\Rozetka\Account $account): void
    {
        $this->em->persist($account);
        $this->em->flush();
    }

    public function saveAll(): void
    {
        $this->em->flush();
    }

    public function findByUsername(string $username): ?\App\Rozetka\Account
    {
        return $this->repository->findOneBy([
            'username' => $username,
        ]);
    }
}