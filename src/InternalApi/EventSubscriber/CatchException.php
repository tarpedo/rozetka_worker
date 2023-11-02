<?php

declare(strict_types=1);

namespace App\InternalApi\EventSubscriber;

use App\Kernel\Exception\BadRequestResponseData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CatchException implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $event->stopPropagation();
        $e = $event->getThrowable();

        if ($e instanceof BadRequestResponseData) {
            $event->setResponse(
                new JsonResponse([
                    'text' => $e->getMessage(),
                    'errors' => $e->getAdditionalData(),
                ], Response::HTTP_BAD_REQUEST)
            );
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException'],
        ];
    }
}
