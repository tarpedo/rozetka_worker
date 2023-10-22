<?php

namespace App\ThirdParty\Amazon\Sqs\Message;

use App\ThirdParty\Amazon\Sqs\MessageInterface;

class Unknown implements MessageInterface
{
    public const NAME = 'unknown';

    public function __construct(private readonly string $name)
    {
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getData(): array
    {
        return ['name' => $this->name];
    }
}