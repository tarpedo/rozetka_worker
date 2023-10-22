<?php

declare(strict_types=1);

namespace App\ThirdParty\RozetkaApi\Service;

class CredentialsRetrieve
{
    public function __construct(
        private readonly \App\ThirdParty\RozetkaApi\ConnectorInterface $connector,
    ) {
    }

    public function process(
        string $username,
        string $encodedPassword
    ): \App\Kernel\ArrayWrapper {
        $command = new \App\ThirdParty\RozetkaApi\Command\Account\Login(
            $username,
            $encodedPassword,
        );

        return $this->connector->single(
            new \App\ThirdParty\RozetkaApi\Account(),
            $command,
        );
    }
}