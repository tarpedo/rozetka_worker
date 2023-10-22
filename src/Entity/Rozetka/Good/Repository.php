<?php

declare(strict_types=1);

namespace App\Entity\Rozetka\Good;

use App\Repository\Rozetka\GoodInterface;

class Repository implements GoodInterface
{
    private \Doctrine\ORM\EntityRepository $repository;

    public function __construct(
        private readonly \Doctrine\ORM\EntityManagerInterface $em,
    ) {
        $this->repository = $this->em->getRepository(\App\Entity\Rozetka\Good::class);
    }

    public function create(\App\Entity\Rozetka\Good $account): void
    {
        $this->em->persist($account);
        $this->em->flush();
    }

    public function saveAll(): void
    {
        $this->em->flush();
    }

    public function findByRzItemId(int $rzItemId): ?\App\Entity\Rozetka\Good
    {
        return $this->repository->findOneBy([
            'rzItemId' => $rzItemId,
        ]);
    }
}