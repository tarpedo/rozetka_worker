<?php

declare(strict_types=1);

namespace App\Kernel\FileStorage\Engine;

class LocalFactory
{
    public function create(string $storagePath): \App\Kernel\FileStorage\Engine\Local
    {
        return new \App\Kernel\FileStorage\Engine\Local($storagePath);
    }
}