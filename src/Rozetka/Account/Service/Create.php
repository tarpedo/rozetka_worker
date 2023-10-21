<?php

declare(strict_types=1);

namespace App\Rozetka\Account\Service;

use App\Entity\Rozetka\Account\MarketInfo;
use App\Entity\Rozetka\Account\SellerInfo;
use App\Repository\Rozetka\AccountInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class Create
{
    public function __construct(
        private readonly AccountInterface $repository,
        private readonly \App\Rozetka\Api\Service\CredentialsRetrieve $credentialsRetrieve,
        public readonly EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function process(
        string $username,
        string $encodedPassword,
    ): ?\App\Entity\Rozetka\Account {
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
            $account = new \App\Entity\Rozetka\Account($username, $encodedPassword, $sellerInfo, $marketInfo);

            $this->repository->create($account);

            $this->eventDispatcher->dispatch(new \App\Rozetka\Account\Event\Created($account));
        }

        $account->setPassword($encodedPassword);
        $account->setMarketInfo($marketInfo);
        $account->setSellerInfo($sellerInfo);

        $this->repository->saveAll();

        return $account;
    }
}