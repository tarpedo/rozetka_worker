<?php

declare(strict_types=1);

namespace App\Rozetka\Api;

class ProcessorFactory
{
    public function __construct(
        private readonly ConnectorInterface $connector,
    ) {
    }

    public function create(\App\Rozetka\Account $account): Processor
    {
        return new Processor(
            $account,
            $this->connector,
        );
    }
}