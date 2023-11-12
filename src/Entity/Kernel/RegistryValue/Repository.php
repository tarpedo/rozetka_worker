<?php

declare(strict_types=1);

namespace App\Entity\Kernel\RegistryValue;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class Repository extends ServiceEntityRepository implements \App\Repository\Kernel\RegistryValueInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, \App\Entity\Kernel\RegistryValue::class);
    }

    public function save(\App\Entity\Kernel\RegistryValue $registryValue): void
    {
        $this->_em->persist($registryValue);
        $this->_em->flush();
    }

    public function delete(\App\Entity\Kernel\RegistryValue $registryValue): void
    {
        $this->_em->remove($registryValue);
        $this->_em->flush();
    }

    /** @return \App\Entity\Kernel\RegistryValue[] */
    public function searchByKey(string $key): array
    {
        return $this->createQueryBuilder('r')
            ->where('r.key LIKE :key')
            ->setParameter('key', $key)
            ->getQuery()->getResult();
    }

    public function findByKey(string $key): ?\App\Entity\Kernel\RegistryValue
    {
        return $this->find($key);
    }
}