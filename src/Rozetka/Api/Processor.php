<?php

declare(strict_types=1);

namespace App\Rozetka\Api;

class Processor
{
    public function __construct(
        private readonly \App\Rozetka\Account $account,
        private readonly \App\Rozetka\Api\ConnectorInterface $connector
    ) {
    }

    public function single(\App\Rozetka\Api\CommandInterface $command)
    {
        //$apiAccount = $this->
    }

    public function createApiAccount()
    {
        //return new Account();
    }
}