<?php

declare(strict_types=1);

namespace App\Rozetka\Api;

class Account
{
    public function __construct(
        private readonly ?string $accessToken = null,
    ) {
    }

    public function isGrantless(): bool
    {
        return $this->accessToken === null;
    }

    public function getAccessToken(): ?string
    {
        if ($this->isGrantless()) {
            throw new \App\Kernel\Exception\Logic('Account does not have access token');
        }

        return $this->accessToken;
    }
}