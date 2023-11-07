<?php

declare(strict_types=1);

namespace App\PrivateApi\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;

class InitAttributes implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    public function process(\Symfony\Component\HttpKernel\Event\ControllerEvent $event): void
    {
        $request = $event->getRequest();
        foreach ($event->getAttributes() as $name => $attributes) {
            foreach ($attributes as $attribute) {
                $request->attributes->set($name, $attribute);
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => ['process', 100],
        ];
    }
}
