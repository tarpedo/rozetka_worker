<?php

declare(strict_types=1);

namespace App\Message\Rozetka\AllGoodsPageNeedDownload;

use App\ThirdParty\Amazon\Sqs\MessageFactoryInterface;
use App\ThirdParty\Amazon\Sqs\MessageInterface;

class MessageFactory implements MessageFactoryInterface
{
    public function __construct(
        private readonly \Psr\Log\LoggerInterface $logger,
    ) {
    }

    public static function getName(): string
    {
        return Message::NAME;
    }

    public static function create(array $data): MessageInterface
    {
        var_dump($data);

        $actionDate = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['action_date'])
            ->setTimezone(new \DateTimeZone('UTC'));

        return new Message(
            $data['username'],
            $data['page'],
            $actionDate
        );
    }
}