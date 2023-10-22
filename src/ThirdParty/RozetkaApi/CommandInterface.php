<?php

declare(strict_types=1);

namespace App\ThirdParty\RozetkaApi;

interface CommandInterface
{
    public function getName(): string;
    public function getRequest(): \GuzzleHttp\Psr7\Request;
    public function parseResult(array $data): array;
}