<?php

declare(strict_types=1);

namespace App\Rozetka\Api\Command\Goods;

class All implements \App\Rozetka\Api\CommandInterface
{
    public function __construct(private readonly int $page = 1)
    {
    }

    public function getName(): string
    {
        return 'Goods/All';
    }

    public function getRequest(): \GuzzleHttp\Psr7\Request
    {
        $request = new \GuzzleHttp\Psr7\Request(
            'GET',
            '/goods/all',
        );

        /** @psalm-suppress InvalidArgument */
        $uri = \GuzzleHttp\Psr7\Uri::withQueryValues($request->getUri(), [
            'page' => $this->page,
        ]);

        return $request->withUri($uri);
    }

    public function parseResult(array $data): array
    {
        return $data;
    }
}