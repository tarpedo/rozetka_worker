<?php

declare(strict_types=1);

namespace App\Admin\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\HttpUtils;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    public function __construct(
        private readonly Provider $provider,
        private readonly HttpUtils $httpUtils,
        private readonly RouterInterface $router,
    ) {
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->httpUtils->generateUri($request, 'admin_login_index');
    }

    public function authenticate(Request $request): Passport
    {
        $email = trim($request->request->get('email'));
        $password = trim($request->request->get('password'));

        $user = $this->provider->loadUserByIdentifier($email);

        $userBadge = new UserBadge(
            $user->getUserIdentifier(),
            [$this->provider, 'loadUserByIdentifier']
        );

        return new Passport(
            $userBadge,
            new PasswordCredentials($password)
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->router->generate('admin_index'));
    }

    public function supports(\Symfony\Component\HttpFoundation\Request $request): bool
    {
        return $request->isMethod('POST')
            && $this->httpUtils->checkRequestPath($request, 'admin_login_process');
    }
}