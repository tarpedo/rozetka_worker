<?php

namespace App\Rozetka\Account;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable()]
class SellerInfo
{
    #[ORM\Column(name: 'seller_fio', type: Types::STRING, length: 250, nullable: false)]
    private string $sellerFio;

    #[ORM\Column(name: 'seller_email', type: Types::STRING, length: 250, nullable: false)]
    private string $sellerEmail;

    public function __construct(
        string $sellerFio,
        string $sellerEmail,
    ) {
        $this->sellerFio = $sellerFio;
        $this->sellerEmail = $sellerEmail;
    }

    public function getSellerFio(): string
    {
        return $this->sellerFio;
    }

    public function getSellerEmail(): string
    {
        return $this->sellerEmail;
    }
}