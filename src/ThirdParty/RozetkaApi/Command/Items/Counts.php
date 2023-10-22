<?php

declare(strict_types=1);

namespace App\ThirdParty\RozetkaApi\Command\Items;

/** @deprecated Use "Goods/Counts" command */
class Counts implements \App\ThirdParty\RozetkaApi\CommandInterface
{
    public function getName(): string
    {
        return 'Items/Counts';
    }

    public function getRequest(): \GuzzleHttp\Psr7\Request
    {
        return new \GuzzleHttp\Psr7\Request(
            'GET',
            '/items/counts',
        );
    }

    public function parseResult(array $data): array
    {
        return $data;
    }
}