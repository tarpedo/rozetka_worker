<?php

declare(strict_types=1);

namespace App\Rozetka\Api;

class ClientFactory
{
    public function __construct(
        private readonly int $connectionTimeout = 5,
        private readonly int $timeout = 30,
    ) {
    }

    public function create(): \GuzzleHttp\Client
    {
        return new \GuzzleHttp\Client([
            \GuzzleHttp\RequestOptions::CONNECT_TIMEOUT => $this->connectionTimeout,
            \GuzzleHttp\RequestOptions::TIMEOUT => $this->timeout,
            \GuzzleHttp\RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }
}