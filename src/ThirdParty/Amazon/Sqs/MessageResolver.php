<?php

declare(strict_types=1);

namespace App\ThirdParty\Amazon\Sqs;

class MessageResolver
{
    /** @var array<string, MessageFactoryInterface> */
    private array $factories = [];

    /** @param MessageFactoryInterface[] $messageFactories */
    public function __construct(private readonly iterable $messageFactories = [])
    {
    }

    public function resolve(string $name, array $rawData): MessageInterface
    {
        if ($name === Message\NotValid::NAME) {
            return new Message\NotValid($rawData);
        }

        $this->init();

        $factory = $this->factories[$name] ?? null;
        if ($factory === null) {
            return new Message\Unknown($name);
        }

        return $factory::create($rawData);
    }

    private function init(): void
    {
        if (!empty($this->factories)) {
            return;
        }

        foreach ($this->messageFactories as $messageFactory) {
            $this->factories[$messageFactory::getName()] = $messageFactory;
        }
    }
}