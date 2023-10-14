<?php

declare(strict_types=1);

namespace App\Cron\Task\RozetkaCheckAccount;

use App\Rozetka\Account\MarketInfo;
use App\Rozetka\Account\SellerInfo;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class Handler
{
    public function __construct(
        private readonly \App\Rozetka\Account\RepositoryInterface $repository,
    ) {
    }

    public function __invoke(Message $message): void
    {
        $this->repository->create(
            new \App\Rozetka\Account(
                'test_username'.rand(),
                'test_password',
                new SellerInfo(
                    'test_fio',
                    'test_email',
                ),
                new MarketInfo(
                    1,
                    'title'
                )
            )
        );
    }
}