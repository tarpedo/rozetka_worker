<?php

declare(strict_types=1);

namespace App\Kernel\Exception;

interface AdditionalDataInterface
{
    public function getAdditionalData(): array;
}