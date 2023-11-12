<?php

namespace App\Repository\Kernel;

interface RegistryValueInterface
{
    public function save(\App\Entity\Kernel\RegistryValue $registryValue): void;

    public function delete(\App\Entity\Kernel\RegistryValue $registryValue): void;

    public function findByKey(string $key): ?\App\Entity\Kernel\RegistryValue;

    /** @return \App\Entity\Kernel\RegistryValue[] */
    public function searchByKey(string $key): array;
}