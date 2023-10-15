<?php

declare(strict_types=1);

namespace App\Kernel\Exception;

trait AdditionalDataTrait
{
    private array $additionalData = [];

    public function getAdditionalData(): array
    {
        return $this->additionalData;
    }
}