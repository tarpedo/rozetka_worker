<?php

declare(strict_types=1);

namespace App\ThirdParty\RozetkaApi;

class AccessTokenFactory
{
    private const CACHE_LIFETIME = 30;

    public function __construct(
        private readonly \App\ThirdParty\RozetkaApi\Service\CredentialsRetrieve $credentialsRetrieve,
        private readonly \Symfony\Contracts\Cache\CacheInterface $cache,
    ) {
    }

    public function create(\App\Entity\Rozetka\Account $account): ?string
    {
        return $this->cache->get(
            $this->prepareCacheKey($account->getId()),
            function (\Symfony\Contracts\Cache\ItemInterface $item, &$save) use ($account) {
                $item->expiresAfter(self::CACHE_LIFETIME);

                $accountInfo = $this->credentialsRetrieve->process($account->getUsername(), $account->getPassword());

                if ($accountInfo->get('success') === false) {
                    $save = false;
                    return null;
                }

                return $accountInfo->get('content/access_token');
            },
        );
    }

    private function prepareCacheKey(int $accountId): string
    {
        return "app.rozetka.api.access_token.{$accountId}";
    }
}