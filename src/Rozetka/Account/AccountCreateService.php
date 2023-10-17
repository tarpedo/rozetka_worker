<?php

declare(strict_types=1);

namespace App\Rozetka\Account;

use App\Rozetka\Account;
use Psr\EventDispatcher\EventDispatcherInterface;

class AccountCreateService
{
    public function __construct(
        private readonly RepositoryInterface $repository,
        private readonly Account\Credentials\Retrieve $credentialsRetrieve,
        public readonly EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function process(
        string $username,
        string $encodedPassword,
    ): ?Account {
        $accountInfo = $this->credentialsRetrieve->process($username, $encodedPassword);

        if ($accountInfo->get('success') === false) {
            return null;
        }

        $sellerInfo = new SellerInfo(
            $accountInfo->get('content/seller/fio'),
            $accountInfo->get('content/seller/email'),
        );

        $marketInfo = new MarketInfo(
            $accountInfo->get('content/market/id'),
            $accountInfo->get('content/market/title'),
        );

        $account = $this->repository->findByUsername($username);
        if ($account === null) {
            $account = new Account($username, $encodedPassword, $sellerInfo, $marketInfo);

            $this->repository->create($account);

            $this->eventDispatcher->dispatch(new Account\Event\AccountCreated($account));
        }

        $account->setPassword($encodedPassword);
        $account->setMarketInfo($marketInfo);
        $account->setSellerInfo($sellerInfo);

        $this->repository->saveAll();

        return $account;
    }
}