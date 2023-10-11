<?php

declare(strict_types=1);

namespace App\Kernel\FileStorage;

interface EngineInterface
{
    public function isFileExist(string $path): bool;

    public function removeFile(string $path): bool;

    public function getFileData(string $path): ?string;

    public function putFileData(string $path, string $data): void;
}