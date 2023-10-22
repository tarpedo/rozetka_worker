<?php

namespace App\ThirdParty\Amazon\Sqs\Message;

use App\ThirdParty\Amazon\Sqs\MessageInterface;

class NotValid implements MessageInterface
{
    public const NAME = 'not_valid';

    public function __construct(private readonly array $rawData)
    {
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getData(): array
    {
        return $this->rawData;
    }
}