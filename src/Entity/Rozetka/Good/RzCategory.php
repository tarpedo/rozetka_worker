<?php

declare(strict_types=1);

namespace App\Entity\Rozetka\Good;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class RzCategory
{
    #[ORM\Column(name: 'rz_category_id', type: Types::INTEGER, length: 10, nullable: true)]
    private int $id;

    #[ORM\Column(name: 'rz_category_title', type: Types::STRING, length: 250, nullable: true)]
    private string $title;

    public function __construct(
        int $id,
        string $title,
    ) {
        $this->id = $id;
        $this->title = $title;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}