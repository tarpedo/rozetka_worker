<?php

declare(strict_types=1);

namespace App\InternalApi\EventSubscriber;

use App\Kernel\Exception\BadRequestResponseData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ValidateSchema implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    public const REQUEST_SCHEMA_PATH = './request.json';

    private const API_ROUTE_PREFIX = '/api/';

    public function __construct(
        private readonly \App\Kernel\Tools\JsonSchemaValidator $jsonSchemaValidator,
        private readonly \Symfony\Component\Filesystem\Filesystem $filesystem,
    ) {
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $request = $event->getRequest();

        if (!$this->isApi($request) || !$this->isValidRequestMethod($request)) {
            return;
        }

        $path = $this->resolveControllerPath($request).substr(self::REQUEST_SCHEMA_PATH, 1);
        if (!$this->filesystem->exists($path)) {
            return;
        }

        $errors = $this->jsonSchemaValidator->isValid($this->readData($path), $request->toArray());

        if (!empty($errors)) {
            throw new BadRequestResponseData('Request data not valid', $errors);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController'],
        ];
    }

    private function resolveControllerPath(Request $request): string
    {
        $controller = $request->attributes->get('_controller');

        [$className,] = explode('::', $controller, 2);

        return dirname((new \ReflectionClass($className))->getFileName());
    }

    private function readData(string $path): string
    {
        $result = file_get_contents($path);
        if ($result === false) {
            throw new \RuntimeException('Unable to read schema data.');
        }

        return $result;
    }

    private function isApi(Request $request): bool
    {
        return str_starts_with($request->getPathInfo(), self::API_ROUTE_PREFIX);
    }

    private function isValidRequestMethod(Request $request): bool
    {
        return in_array($request->getMethod(), ['GET', 'POST']);
    }
}
