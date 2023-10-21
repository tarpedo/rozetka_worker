<?php

declare(strict_types=1);

namespace App\Cron;

use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Symfony\Contracts\Cache\CacheInterface;

#[AsSchedule('cron')]
class TaskProvider implements ScheduleProviderInterface
{
    // https://www.codinghood.de/news/new-in-symfony-6-3-scheduler-component/
    public function __construct(
        private readonly LockFactory $lockFactory,
        private readonly CacheInterface $cache,
    ) {
    }

    public function getSchedule(): Schedule
    {
        return (new Schedule())
            ->add(
                RecurringMessage::every(
                    '1 minute',
                    new Rozetka\AccountCheckMessage()
                )
            )
            ->lock($this->lockFactory->createLock('cron'))
            ->stateful($this->cache);
    }
}