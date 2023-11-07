<?php

declare(strict_types=1);

namespace App\PrivateApi\EventSubscriber;

use App\Kernel\Exception\BadRequestResponseData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ValidateSchema implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    public const REQUEST_SCHEMA_PATH = './request.json';
    public const RESPONSE_SCHEMA_PATH = './response.json';

    private const API_ROUTE_PREFIX = '/api/';

    public function __construct(
        private readonly \App\Kernel\Tools\JsonSchemaValidator $jsonSchemaValidator,
        private readonly \Symfony\Component\Filesystem\Filesystem $filesystem,
    ) {
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $request = $event->getRequest();

        if (!$this->isValidRequestMethod($request)) {
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

    public function onKernelResponse(ResponseEvent $event): void
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            return;
        }

        $path = $this->resolveControllerPath($request).substr(self::RESPONSE_SCHEMA_PATH, 1);
        if (!$this->filesystem->exists($path)) {
            return;
        }

        $response = json_decode($response->getContent(), true);
        if (isset($response['error'])) {
            return;
        }

        $errors = $this->jsonSchemaValidator->isValid($this->readData($path), $response['data']);

        if (!empty($errors)) {
            throw new BadRequestResponseData('Response data not valid', $errors);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', 70],
            KernelEvents::RESPONSE   => ['onKernelResponse'],
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

    private function isValidRequestMethod(Request $request): bool
    {
        return in_array($request->getMethod(), ['GET', 'POST']);
    }
}
