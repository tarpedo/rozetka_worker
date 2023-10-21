<?php

declare(strict_types=1);

namespace App\Entity\Rozetka\Account;

use App\Repository\Rozetka\AccountInterface;

class Repository implements AccountInterface
{
    private \Doctrine\ORM\EntityRepository $repository;

    public function __construct(
        private readonly \Doctrine\ORM\EntityManagerInterface $em,
    ) {
        $this->repository = $this->em->getRepository(\App\Entity\Rozetka\Account::class);
    }

    public function create(\App\Entity\Rozetka\Account $account): void
    {
        $this->em->persist($account);
        $this->em->flush();
    }

    public function saveAll(): void
    {
        $this->em->flush();
    }

    public function findByUsername(string $username): ?\App\Entity\Rozetka\Account
    {
        return $this->repository->findOneBy([
            'username' => $username,
        ]);
    }
}