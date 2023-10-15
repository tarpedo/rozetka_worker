<?php

declare(strict_types=1);

namespace App\Rozetka\Api\Command\Account;

class Login implements \App\Rozetka\Api\CommandInterface
{
    public function __construct(
        private readonly string $username,
        private readonly string $encodedPassword,
    ) {
    }

    public function getName(): string
    {
        return 'Account/Login';
    }

    public function getRequest(): \GuzzleHttp\Psr7\Request
    {
        $body = <<<BODY
            {
                "username": "{$this->username}",
                "password": "{$this->encodedPassword}"
            }
        BODY;

        return new \GuzzleHttp\Psr7\Request(
            'POST',
            '/sites',
            body: $body
        );
    }

    public function parseResult(array $data): array
    {
        return $data;
    }
}