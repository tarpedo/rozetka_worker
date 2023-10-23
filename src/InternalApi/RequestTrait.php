<?php

declare(strict_types=1);

namespace App\InternalApi;

use App\Kernel\ArrayWrapper;

trait RequestTrait
{
    protected function parseJson(string $requestJson): ArrayWrapper
    {
        try {
            return new ArrayWrapper(
                json_decode(
                    json: $requestJson,
                    associative: true,
                    flags: JSON_THROW_ON_ERROR
                )
            );
        } catch (\JsonException $e) {
            return new ArrayWrapper();
        }
    }

}