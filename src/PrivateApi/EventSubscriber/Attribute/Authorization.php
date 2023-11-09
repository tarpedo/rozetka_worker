<?php

declare(strict_types=1);

namespace App\PrivateApi\EventSubscriber\Attribute;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Authorization
{
    public function __construct(public readonly array $allowedApps)
    {
    }
}
