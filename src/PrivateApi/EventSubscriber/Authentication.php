<?php

declare(strict_types=1);

namespace App\PrivateApi\EventSubscriber;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Authentication implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    public const KNOWN_APP_NAME = 'X-App';

    public function __construct(
        private readonly \App\PrivateApi\KnownApp\Repository $knownAppRepository,
    ) {
    }

    public function process(\Symfony\Component\HttpKernel\Event\ControllerEvent $event): void
    {
        /** @var Attribute\Authentication $authentication */
        $authentication = $event->getRequest()->attributes->get(Attribute\Authentication::class);
        if ($authentication !== null && !$authentication->required) {
            return;
        }

        $header = $event->getRequest()->headers;
        if (!$header->has('access-token')) {
            throw new UnauthorizedHttpException(
                'Bearer error="invalid_token", error_description="no access-token"',
                'Access Denied: no access-token'
            );
        }

        try {
            /** @var \Lcobucci\JWT\Token\Plain $token */
            $token = $this->createParser()->parse($header->get('access-token'));
        } catch (\Throwable) {
            throw new UnauthorizedHttpException(
                'Bearer error="invalid_token", error_description="broken token"',
                'Access Denied: broken token'
            );
        }

        if ($token->isExpired(\App\Kernel\Tools\Date::createCurrent())) {
            throw new UnauthorizedHttpException(
                'Bearer error="invalid_token", error_description="expired token"',
                'Access Denied: expired token'
            );
        }

        $issuer = $token->claims()->get(\Lcobucci\JWT\Token\RegisteredClaims::ISSUER);
        if (!$this->knownAppRepository->hasApplication($issuer)) {
            throw new UnauthorizedHttpException(
                'Bearer error="invalid_token", error_description="app unknown"',
                'Access Denied: app unknown'
            );
        }

        if (!$this->isValid($token, $this->knownAppRepository->getApplication($issuer)->jwtSecretKey)) {
            throw new UnauthorizedHttpException(
                'Bearer error="invalid_token", error_description="not valid token"',
                'Access Denied: invalid token'
            );
        }

        $event->getRequest()->attributes->set(self::KNOWN_APP_NAME, $issuer);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            \Symfony\Component\HttpKernel\KernelEvents::CONTROLLER => ['process', 90],
        ];
    }

    private function createParser(): \Lcobucci\JWT\Token\Parser
    {
        return new \Lcobucci\JWT\Token\Parser(new \Lcobucci\JWT\Encoding\JoseEncoder());
    }

    private function isValid(\Lcobucci\JWT\Token $token, string $accessKey): bool
    {
        $validator = new \Lcobucci\JWT\Validation\Validator();

        $config = \Lcobucci\JWT\Configuration::forSymmetricSigner(
            new \Lcobucci\JWT\Signer\Hmac\Sha256(),
            \Lcobucci\JWT\Signer\Key\InMemory::plainText($accessKey)
        );

        return $validator->validate(
            $token,
            new \Lcobucci\JWT\Validation\Constraint\SignedWith($config->signer(), $config->signingKey())
        );
    }
}
