<?php

declare(strict_types=1);

namespace App\Rozetka\Account\Event;

class Created
{
    public function __construct(
        public readonly \App\Entity\Rozetka\Account $account,
    ) {
    }
}