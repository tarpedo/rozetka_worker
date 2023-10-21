<?php

declare(strict_types=1);

namespace App\Cron\Rozetka;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class AccountCheckHandler
{
    public function __construct()
    {
    }

    public function __invoke(AccountCheckMessage $message): void
    {
    }
}