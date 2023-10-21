<?php

declare(strict_types=1);

namespace App\Entity\Rozetka\Account;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class SellerInfo
{
    #[ORM\Column(name: 'seller_fio', type: Types::STRING, length: 250, nullable: false)]
    private string $fio;

    #[ORM\Column(name: 'seller_email', type: Types::STRING, length: 250, nullable: false)]
    private string $email;

    public function __construct(
        string $fio,
        string $email,
    ) {
        $this->fio = $fio;
        $this->email = $email;
    }

    public function getFio(): string
    {
        return $this->fio;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}