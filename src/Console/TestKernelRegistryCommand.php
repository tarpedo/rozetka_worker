<?php

declare(strict_types=1);

namespace App\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:test:kernel:registry')]
class TestKernelRegistryCommand extends Command
{
    public const GROUP_NAME = '/amazon_update_product_type_dictionary/';

    public function __construct(
        private readonly \App\Kernel\Registry $registry,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entity = $this->registry->find(
            self::GROUP_NAME,
            $this->prepareRegisterKey(7)
        );

        var_dump($entity);

        $this->registry->delete(
            self::GROUP_NAME,
            $this->prepareRegisterKey(2)
        );

        $this->registry->set(
            '/amazon_update_product_type_dictionary/',
            $this->prepareRegisterKey(7),
            'sfd'
        );

        $registryValues = $this->registry->findByGroup('/amazon_update_product_type_dictionary/');

        var_dump($registryValues);

        $output->writeln('It\'s work!');

        return Command::SUCCESS;
    }

    private function prepareRegisterKey(int $accountId): string
    {
        return "marketplace/id/$accountId";
    }
}