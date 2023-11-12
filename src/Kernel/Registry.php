<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Entity\Kernel\RegistryValue;

class Registry
{
    public function __construct(
        private readonly \App\Repository\Kernel\RegistryValueInterface $repository,
    ) {
    }

    public function set(?string $group, string $key, string $value): void
    {
        $fullKey = $this->createKey($group, $key);

        $registryValue = $this->find($group, $key);

        if ($registryValue !== null) {
            $registryValue->setValue($value);
        } else {
            $registryValue = new RegistryValue(
                $fullKey,
                $value
            );
        }

        $this->repository->save($registryValue);
    }

    public function find(?string $group, string $key): ?\App\Entity\Kernel\RegistryValue
    {
        $fullKey = $this->createKey($group, $key);

        return $this->repository->findByKey($fullKey);
    }

    public function delete(?string $group, string $key): void
    {
        $fullKey = $this->createKey($group, $key);

        $registryValue = $this->repository->findByKey($fullKey);
        if ($registryValue !== null) {
            $this->repository->delete($registryValue);
        }
    }

    public function findByGroup(string $group): array
    {
        $mySqlGroup = rtrim($group, '/').'/%';

        return $this->repository->searchByKey($mySqlGroup);
    }

    private function createKey(?string $group, string $key): string
    {
        if ($group === null) {
            return $key;
        }

        $key = ltrim($key, '/');
        $group = trim($group, '/');

        return "/{$group}/{$key}";
    }

}