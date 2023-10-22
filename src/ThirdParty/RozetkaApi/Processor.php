<?php

declare(strict_types=1);

namespace App\ThirdParty\RozetkaApi;

class Processor
{
    public function __construct(
        private readonly \App\Entity\Rozetka\Account $account,
        private readonly ConnectorInterface $connector,
        private readonly AccessTokenFactory $accessTokenFactory,
    ) {
    }

    public function single(CommandInterface $command): \App\Kernel\ArrayWrapper
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