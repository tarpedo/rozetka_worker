<?php

declare(strict_types=1);

namespace App\Rozetka;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'rozetka_accounts')]
#[ORM\HasLifecycleCallbacks]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    private int $id;

    #[ORM\Column(name: 'username', type: Types::STRING, length: 255, unique: true, nullable: false)]
    private string $username;

    #[ORM\Column(name: 'password', type: Types::STRING, length: 255, nullable: false)]
    private string $password;

    #[ORM\Embedded(class: Account\SellerInfo::class, columnPrefix: false)]
    private Account\SellerInfo $sellerInfo;

    #[ORM\Embedded(class: Account\MarketInfo::class, columnPrefix: false)]
    private Account\MarketInfo $marketInfo;

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
        string $username,
        string $password,
        Account\SellerInfo $sellerInfo,
        Account\MarketInfo $marketInfo,
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->sellerInfo = $sellerInfo;
        $this->marketInfo = $marketInfo;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getSellerInfo(): Account\SellerInfo
    {
        return $this->sellerInfo;
    }

    public function setSellerInfo(Account\SellerInfo $sellerInfo): self
    {
        $this->sellerInfo = $sellerInfo;

        return $this;
    }

    public function getMarketInfo(): Account\MarketInfo
    {
        return $this->marketInfo;
    }

    public function setMarketInfo(Account\MarketInfo $marketInfo): self
    {
        $this->marketInfo = $marketInfo;

        return $this;
    }

    public function getUpdateDate(): \DateTimeImmutable
    {
        return $this->updateDate;
    }

    public function getCreateDate(): \DateTimeImmutable
    {
        return $this->createDate;
    }
}
