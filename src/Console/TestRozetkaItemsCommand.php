<?php

declare(strict_types=1);

namespace App\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:test:rozetka:items')]
class TestRozetkaItemsCommand extends Command
{
    public function __construct(
        private readonly \App\Repository\Rozetka\AccountInterface $repository,
        private readonly \App\ThirdParty\RozetkaApi\ProcessorFactory $processorFactory,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $account = $this->repository->findByUsername('wolfshoplviv');

        $processor = $this->processorFactory->create($account);

        $counts = $processor->single(
            new \App\ThirdParty\RozetkaApi\Command\Goods\OnSale(2, 1)
        );

        var_dump($counts);

        $output->writeln('It\'s work!');

        return Command::SUCCESS;
    }
}