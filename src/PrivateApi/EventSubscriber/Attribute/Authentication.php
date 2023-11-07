<?php

declare(strict_types=1);

namespace App\PrivateApi\EventSubscriber\Attribute;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Authentication
{
    public function __construct(public readonly bool $required = true)
    {
    }
}
