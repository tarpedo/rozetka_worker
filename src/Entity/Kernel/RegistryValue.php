<?php

declare(strict_types=1);

namespace App\Entity\Kernel;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: \App\Entity\Kernel\RegistryValue\Repository::class)]
#[ORM\Table(name: 'kernel_registry')]
#[ORM\HasLifecycleCallbacks]
class RegistryValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(name: '`key`', type: Types::STRING, length: 255, unique: true, nullable: false)]
    private string $key;

    #[ORM\Column(name: 'value', type: Types::STRING, length: 255, nullable: false)]
    private string $value;

    #[ORM\Column(name: 'update_date', type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $updateDate;

    #[ORM\Column(name: 'create_date', type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createDate;

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->updateDate = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $this->createDate = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updateDate = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
    }

    public function __construct(
        string $key,
        string $value,
    ) {
        $this->key = $key;
        $this->value = $value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}