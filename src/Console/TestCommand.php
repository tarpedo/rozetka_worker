<?php

declare(strict_types=1);

namespace App\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:test')]
class TestCommand extends Command
{
    public function __construct(
        private \App\Kernel\FileStorage\EngineInterface $fileStorage,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->fileStorage->putFileData('test.txt', 'hello');

        //$storage = new StorageClient(['keyFilePath' => '/path/to/my-project-key.json']);

        $output->writeln('Whoa!');

        return Command::SUCCESS;
    }
}