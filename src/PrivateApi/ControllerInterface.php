<?php

declare(strict_types=1);

namespace App\PrivateApi;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

interface ControllerInterface
{
    public function process(Request $request): JsonResponse;
}
