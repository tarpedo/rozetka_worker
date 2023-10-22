<?php

declare(strict_types=1);

namespace App\ThirdParty\Amazon\Sqs;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.amazon.sqs.message.factory')]
interface MessageFactoryInterface
{
    public static function getName(): string;

    public static function create(array $data): MessageInterface;
}