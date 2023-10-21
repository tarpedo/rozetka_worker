<?php

declare(strict_types=1);

namespace App\Entity\Rozetka;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'rozetka_goods')]
#[ORM\HasLifecycleCallbacks]
class Good
{
    #[ORM\Id]
    #[ORM\Column(name: 'rz_item_id', type: Types::INTEGER, length: 255, unique: true, nullable: false)]
    private int $rzItemId;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 255, nullable: false)]
    private string $name;

    #[ORM\Column(name: 'url', type: Types::STRING, length: 400, nullable: false)]
    private string $url;

    #[ORM\Column(name: 'price', type: Types::INTEGER, length: 20, nullable: false)]
    private int $price;

    #[ORM\Column(name: 'price_old', type: Types::INTEGER, length: 20, nullable: false)]
    private int $priceOld;

    #[ORM\Embedded(class: Good\RzCategory::class, columnPrefix: false)]
    private Good\RzCategory $rzCategory;

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
        int $rzItemId,
        string $name,
        string $url,
        int $price,
        int $priceOld,
        Good\RzCategory $rzCategory,
    ) {
        $this->rzItemId = $rzItemId;
        $this->name = $name;
        $this->url = $url;
        $this->price = $price;
        $this->priceOld = $priceOld;
        $this->rzCategory = $rzCategory;
    }

    public function getRzItemId(): int
    {
        return $this->rzItemId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getPriceOld(): int
    {
        return $this->priceOld;
    }

    public function getRzCategory(): Good\RzCategory
    {
        return $this->rzCategory;
    }

    public function setRzCategory(Good\RzCategory $rzCategory): void
    {
        $this->rzCategory = $rzCategory;
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