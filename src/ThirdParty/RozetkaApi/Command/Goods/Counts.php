<?php

declare(strict_types=1);

namespace App\ThirdParty\RozetkaApi\Command\Goods;

class Counts implements \App\ThirdParty\RozetkaApi\CommandInterface
{
    public function getName(): string
    {
        return 'Goods/Counts';
    }

    public function getRequest(): \GuzzleHttp\Psr7\Request
    {
        return new \GuzzleHttp\Psr7\Request(
            'GET',
            '/goods/counts',
        );
    }

    public function parseResult(array $data): array
    {
        return $data;
    }
}