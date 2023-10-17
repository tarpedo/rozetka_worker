<?php

declare(strict_types=1);

namespace App\Rozetka\Api;

class Processor
{
    public function __construct(
        private readonly \App\Rozetka\Account $account,
        private readonly \App\Rozetka\Api\ConnectorInterface $connector,
        private readonly \App\Rozetka\Api\AccessTokenFactory $accessTokenFactory,
    ) {
    }

    public function single(\App\Rozetka\Api\CommandInterface $command): \App\Kernel\ArrayWrapper
    {
        $apiAccount = $this->createApiAccount();

        return $this->connector->single(
            $apiAccount,
            $command,
        );
    }

    public function createApiAccount(): Account
    {
        return new Account($this->accessTokenFactory->create($this->account));
    }
}