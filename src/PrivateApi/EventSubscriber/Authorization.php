<?php

declare(strict_types=1);

namespace App\PrivateApi\EventSubscriber;

class Authorization implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    public function process(\Symfony\Component\HttpKernel\Event\ControllerEvent $event): void
    {
        $knownApp = $event->getRequest()->attributes->get(Authentication::KNOWN_APP_NAME);

        /** @var \App\PrivateApi\EventSubscriber\Attribute\Authorization $annotation */
        $annotation = $event->getRequest()->attributes->get(\App\PrivateApi\EventSubscriber\Attribute\Authorization::class);
        if (!empty($annotation) && !in_array($knownApp, $annotation->allowedApps)) {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Access Denied: app unauthorized');
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            \Symfony\Component\HttpKernel\KernelEvents::CONTROLLER => [
                ['process', 80],
            ],
        ];
    }
}