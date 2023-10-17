<?php

declare(strict_types=1);

namespace App\Cron\Task\RozetkaCheckAccount;

use App\Rozetka\Account\MarketInfo;
use App\Rozetka\Account\SellerInfo;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class Handler
{
    public function __construct()
    {
    }

    public function __invoke(Message $message): void
    {
    }
}