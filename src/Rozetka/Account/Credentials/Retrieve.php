<?php

declare(strict_types=1);

namespace App\Rozetka\Account\Credentials;

class Retrieve
{
    public function __construct(
        private readonly \App\Rozetka\Api\ConnectorInterface $connector,
    ) {
    }

    public function process(
        string $username,
        string $encodedPassword
    ): array {
        $command = new \App\Rozetka\Api\Command\Account\Login(
            $username,
            $encodedPassword,
        );

        return $this->connector->single(
            new \App\Rozetka\Api\Account(),
            $command,
        );
    }
}