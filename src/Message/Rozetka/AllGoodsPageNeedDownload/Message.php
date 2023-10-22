<?php

namespace App\Message\Rozetka\AllGoodsPageNeedDownload;

use App\ThirdParty\Amazon\Sqs\MessageInterface;

class Message implements MessageInterface
{
    public const NAME = 'rozetka_all_goods_page_need_download';

    public function __construct(
        public readonly string $username,
        public readonly int $page,
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
            'order' => $this->page,
            'action_date' => $this->actionDate->format('Y-m-d H:i:s'),
        ];
    }
}