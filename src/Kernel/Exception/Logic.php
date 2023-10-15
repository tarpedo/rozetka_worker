<?php

declare(strict_types=1);

namespace App\Kernel\Exception;

class Logic extends \LogicException implements AdditionalDataInterface
{
    use AdditionalDataTrait;

    public function __construct(
        string $message = "",
        array $additionalData = [],
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->additionalData = $additionalData;
    }
}