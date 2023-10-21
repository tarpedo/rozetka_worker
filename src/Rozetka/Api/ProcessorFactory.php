<?php

declare(strict_types=1);

namespace App\Rozetka\Api;

class ProcessorFactory
{
    public function __construct(
        private readonly ConnectorInterface $connector,
        private readonly AccessTokenFactory $accessTokenFactory,
    ) {
    }

    public function create(\App\Entity\Rozetka\Account $account): Processor
    {
        return new Processor(
            $account,
            $this->connector,
            $this->accessTokenFactory,
        );
    }
}