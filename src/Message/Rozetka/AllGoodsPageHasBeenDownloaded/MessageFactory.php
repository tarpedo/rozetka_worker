<?php

declare(strict_types=1);

namespace App\Message\Rozetka\AllGoodsPageHasBeenDownloaded;

class MessageFactory implements \App\ThirdParty\Amazon\Sqs\MessageFactoryInterface
{
    public static function getName(): string
    {
        return Message::NAME;
    }

    public static function create(array $data): \App\ThirdParty\Amazon\Sqs\MessageInterface
    {
        $actionDate = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['action_date'])
            ->setTimezone(new \DateTimeZone('UTC'));

        return new Message(
            $data['username'],
            $data['page'],
            new \App\Kernel\ArrayWrapper($data['data']),
            $actionDate
        );
    }
}