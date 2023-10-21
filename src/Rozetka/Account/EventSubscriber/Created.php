<?php

declare(strict_types=1);

namespace App\Rozetka\Account\EventSubscriber;

class Created implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    public function process(\App\Rozetka\Account\Event\Created $event): void
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            \App\Rozetka\Account\Event\Created::class => 'process',
        ];
    }
}