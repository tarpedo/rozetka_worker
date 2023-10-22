<?php

declare(strict_types=1);

namespace App\Message\Rozetka\AllGoodsPageHasBeenDownloaded;

use App\ThirdParty\Amazon\Sqs\MessageInterface;

class Message implements MessageInterface
{
    public const NAME = 'rozetka_all_goods_page_has_been_download';

    public function __construct(
        public readonly string $username,
        public readonly int $page,
        public readonly \App\Kernel\ArrayWrapper $data,
        public readonly \DateTimeImmutable $actionDate,
    ) {
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getData(): array
    {
        return [
            'username' => $this->username,
            'page' => $this->page,
            'data' => $this->data->toArray(),
            'action_date' => $this->actionDate->format('Y-m-d H:i:s'),
        ];
    }
}