<?php

declare(strict_types=1);

namespace App\ThirdParty\Amazon\Sqs;

interface MessageInterface
{
    public function getName(): string;

    public function getData(): array;
}