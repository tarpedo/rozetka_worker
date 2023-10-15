<?php

declare(strict_types=1);

namespace App\Rozetka\Account\EventSubscriber;

class AccountCreated implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    public function process(\App\Rozetka\Account\Event\AccountCreated $event): void
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            \App\Rozetka\Account\Event\AccountCreated::class => 'process',
        ];
    }
}