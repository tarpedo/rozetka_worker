<?php

declare(strict_types=1);

namespace App\Kernel\FileStorage\Engine;

class Local implements \App\Kernel\FileStorage\EngineInterface
{
    public function __construct(private readonly string $storagePath)
    {
    }

    public function isFileExist(string $path): bool
    {
        return is_file($this->getFullFilePath($path));
    }

    public function removeFile(string $path): bool
    {
        if (!$this->isFileExist($path)) {
            return true;
        }

        return unlink($this->getFullFilePath($path));
    }

    public function getFileData(string $path): ?string
    {
        if (!$this->isFileExist($path)) {
            return null;
        }

        return file_get_contents($this->getFullFilePath($path)) ?? null;
    }

    public function putFileData(string $path, string $data): void
    {
        $dir = dirname($this->getFullFilePath($path));
        !is_dir($dir) && mkdir($dir, recursive: true);

        file_put_contents($this->getFullFilePath($path), $data);
    }

    private function getFullFilePath(string $path): string
    {
        return $this->storagePath . $path;
    }
}