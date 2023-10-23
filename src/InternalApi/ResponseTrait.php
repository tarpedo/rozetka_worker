<?php

declare(strict_types=1);

namespace App\InternalApi;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

trait ResponseTrait
{
    protected function success(array $data = []): JsonResponse
    {
        return new JsonResponse(
            $data,
            Response::HTTP_OK
        );
    }

    protected function error(
        string $text,
        array $details = [],
        int $httpStatus = Response::HTTP_INTERNAL_SERVER_ERROR,
    ): JsonResponse {
        return new JsonResponse(
            [
                'error' => [
                    'text' => $text,
                    'details' => $details,
                ],
            ],
            $httpStatus
        );
    }
}