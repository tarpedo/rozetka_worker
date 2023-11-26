<?php

declare(strict_types=1);

namespace App\Admin\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CatchException implements EventSubscriberInterface
{
    public function __construct(
        private readonly RouterInterface $router,
    ) {
    }

    private const ADMIN_ROUTE_PREFIX = '/admin';

    public function onKernelException(ExceptionEvent $event): void
    {
        if (!$this->isAdminRequest($event->getRequest())) {
            return;
        }

        $event->stopPropagation();
        $e = $event->getThrowable();

        if ($e instanceof AccessDeniedException) {
            $event->setResponse(new RedirectResponse($this->router->generate('admin_login_index')));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 100],
        ];
    }

    private function isAdminRequest(Request $request): bool
    {
        return str_starts_with($request->getPathInfo(), self::ADMIN_ROUTE_PREFIX);
    }
}
