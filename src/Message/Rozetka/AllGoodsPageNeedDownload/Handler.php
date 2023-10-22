<?php

declare(strict_types=1);

namespace App\Message\Rozetka\AllGoodsPageNeedDownload;

use App\Kernel\ArrayWrapper;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class Handler
{
    public function __construct(
        private readonly \Psr\Log\LoggerInterface $logger,
        private readonly \App\Repository\Rozetka\AccountInterface $repository,
        private readonly \Symfony\Component\Messenger\MessageBusInterface $messageBus,
        private readonly \App\ThirdParty\RozetkaApi\ProcessorFactory $processorFactory,
    ) {
    }

    public function __invoke(Message $message): void
    {
        $account = $this->repository->findByUsername($message->username);
        $processor = $this->processorFactory->create($account);

        $goods = $processor->single(new \App\ThirdParty\RozetkaApi\Command\Goods\All($message->page));

        $message = new \App\Message\Rozetka\AllGoodsPageHasBeenDownloaded\Message(
            $message->username,
            $message->page,
            new ArrayWrapper($goods),
            (new \DateTimeImmutable())->setTimezone(new \DateTimeZone('UTC')),
        );

        try {
            $this->messageBus->dispatch($message);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
        }
    }
}
