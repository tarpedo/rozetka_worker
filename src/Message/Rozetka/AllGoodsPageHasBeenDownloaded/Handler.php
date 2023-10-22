<?php

declare(strict_types=1);

namespace App\Message\Rozetka\AllGoodsPageHasBeenDownloaded;

use App\Entity\Rozetka\Good;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class Handler
{
    public function __construct(
        private readonly \App\Repository\Rozetka\AccountInterface $accountRepository,
        private readonly \App\Repository\Rozetka\GoodInterface $goodRepository,
    ) {
    }

    public function __invoke(Message $message): void
    {
        $account = $this->accountRepository->findByUsername($message->username);

        foreach ($message->data->get('content/items') as $item) {
            $good = $this->goodRepository->findByRzItemId($item->get('rz_item_id'));
            if ($good === null) {
                $good = new Good(
                    $item->get('rz_item_id'),
                    $item->get('name'),
                    $item->get('url'),
                    $item->get('price'),
                    $item->get('price_old'),
                    new Good\RzCategory(
                        $item->get('rz_category/id'),
                        $item->get('rz_category/title'),
                    ),
                );

                $good->setAccount($account);

                $this->goodRepository->create($good);
            } else {
                $good->setName($item->get('name'));
                $good->setUrl($item->get('url'));
                $good->setPrice($item->get('price'));
                $good->setPriceOld($item->get('price_old'));
                $good->setRzCategory(
                    new Good\RzCategory(
                        $item->get('rz_category/id'),
                        $item->get('rz_category/title'),
                    )
                );
            }
        }

        $this->goodRepository->saveAll();
    }
}
