<?php

declare(strict_types=1);

namespace App\Rozetka\Account\Event;

class AccountCreated
{
    public function __construct(
        public readonly \App\Rozetka\Account $account,
    ) {
    }
}