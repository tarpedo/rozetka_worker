<?php

declare(strict_types=1);

namespace App\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:dev:jwt:generate')]
class GenerateJwt extends Command
{
    private array $apps;

    public function __construct(
        private readonly array $rawApplications
    ) {
        foreach ($this->rawApplications as ['name' => $name, 'key' => $key]) {
            $this->apps[$name] = $key;
        }

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(
                'Generate JWT token by application. Allowed applications: '
                .implode(', ', array_keys($this->apps))
            )
            ->addArgument('app', InputArgument::REQUIRED, 'Name of Application');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $app = $input->getArgument('app');
        if (!isset($this->apps[$app])) {
            $output->writeln('<error>Unknown Application.</error>');

            return Command::INVALID;
        }

        $configuration = \Lcobucci\JWT\Configuration::forSymmetricSigner(
            new \Lcobucci\JWT\Signer\Hmac\Sha256(),
            \Lcobucci\JWT\Signer\Key\InMemory::plainText($this->apps[$app])
        );

        $currentDate = \App\Kernel\Tools\Date::createCurrent();

        $token = ($configuration->builder())
            ->issuedBy($app)
            ->issuedAt($currentDate)
            ->expiresAt($currentDate->modify("+1 year"))
            ->getToken($configuration->signer(), $configuration->signingKey());

        $output->writeln(sprintf('<info>%s</info>', $token->toString()));

        return Command::SUCCESS;
    }
}