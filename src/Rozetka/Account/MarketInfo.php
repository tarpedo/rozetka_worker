<?php

declare(strict_types=1);

namespace App\Rozetka\Account;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable()]
class MarketInfo
{
    #[ORM\Column(name: 'market_id', type: Types::INTEGER, length: 10, nullable: false)]
    private int $id;

    #[ORM\Column(name: 'market_title', type: Types::STRING, length: 250, nullable: false)]
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