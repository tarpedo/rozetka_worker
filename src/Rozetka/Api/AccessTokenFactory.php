<?php

declare(strict_types=1);

namespace App\Rozetka\Api;

class AccessTokenFactory
{
    public function __construct(
        private readonly \Symfony\Contracts\Cache\CacheInterface $cache,
    ) {
    }

    public function create(\App\Rozetka\Account $account): string
    {
        return $this->cache->get(
            $this->getCacheKey($account->getId()),
            function (\Symfony\Contracts\Cache\ItemInterface $item) use ($account) {
                return '';
            },
        );
    }

    private function getCacheKey(int $accountId): string
    {
        return "app.rozetka.api.access_token.{$accountId}";
    }
}