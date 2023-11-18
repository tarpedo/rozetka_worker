<?php

declare(strict_types=1);

namespace App\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:test:rozetka_good_send_message')]
class TestRozetkaGoodSendMessageCommand extends Command
{
    public function __construct(
        private readonly \Symfony\Component\Messenger\MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $message = new \App\Message\Rozetka\AllGoodsPageNeedDownload\Message(
            'wolfshoplviv',
            2,
            (new \DateTimeImmutable())->setTimezone(new \DateTimeZone('UTC')),
        );

        try {
            $this->messageBus->dispatch($message);
        } catch (\Throwable $e) {
            print(json_encode(['exception' => $e->getMessage()]));
        }

        return Command::SUCCESS;
    }
}