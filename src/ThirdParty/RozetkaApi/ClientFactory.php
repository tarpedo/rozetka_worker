<?php

declare(strict_types=1);

namespace App\ThirdParty\RozetkaApi;

class ClientFactory
{
    public function __construct(
        private readonly int $connectionTimeout = 5,
        private readonly int $timeout = 30,
    ) {
    }

    public function create(
        Account $account,
    ): \GuzzleHttp\Client {
        $headers = [
            'Content-Type' => 'application/json',
            'Content-Language' => 'uk',
        ];

        if (!$account->isGrantless()) {
            $headers['Authorization'] = 'Bearer '.$account->getAccessToken();
        }

        return new \GuzzleHttp\Client([
            \GuzzleHttp\RequestOptions::CONNECT_TIMEOUT => $this->connectionTimeout,
            \GuzzleHttp\RequestOptions::TIMEOUT => $this->timeout,
            \GuzzleHttp\RequestOptions::HEADERS => $headers,
        ]);
    }
}