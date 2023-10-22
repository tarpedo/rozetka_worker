<?php

declare(strict_types=1);

namespace App\ThirdParty\RozetkaApi\Command\Goods;

class OnSale implements \App\ThirdParty\RozetkaApi\CommandInterface
{
    private const PAGE_SIZE = 100;

    public function __construct(
        private readonly int $page = 1,
        private readonly ?int $pageSize = self::PAGE_SIZE,
    ) {
    }

    public function getName(): string
    {
        return 'Goods/OnSale';
    }

    public function getRequest(): \GuzzleHttp\Psr7\Request
    {
        $request = new \GuzzleHttp\Psr7\Request(
            'GET',
            '/goods/on-sale',
        );

        /** @psalm-suppress InvalidArgument */
        $uri = \GuzzleHttp\Psr7\Uri::withQueryValues($request->getUri(), [
            'pageSize' => $this->pageSize,
            'page' => $this->page,
        ]);

        return $request->withUri($uri);
    }

    public function parseResult(array $data): array
    {
        return $data;
    }
}