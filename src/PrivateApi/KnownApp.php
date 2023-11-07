<?php

declare(strict_types=1);

namespace App\PrivateApi;

class KnownApp
{
    public function __construct(
        public readonly string $name,
        public readonly string $jwtSecretKey
    ) {
    }
}
