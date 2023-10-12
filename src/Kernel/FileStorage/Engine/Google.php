<?php

declare(strict_types=1);

namespace App\Kernel\FileStorage\Engine;

use App\Kernel\FileStorage\EngineInterface;

class Google implements EngineInterface
{
    public function __construct(
        private readonly \Google\Cloud\Storage\Bucket $bucket,
    ) {
    }

    public function isFileExist(string $path): bool
    {
        return $this->bucket->object($path)->exists();
    }

    public function removeFile(string $path): void
    {
        if (!$this->isFileExist($path)) {
            return;
        }

        $this->bucket->object($path)->delete();
    }

    public function getFileData(string $path): ?string
    {
        try {
            $object = $this->bucket->object($path);

            return $object->downloadAsString();
        } catch (\Throwable) {
            return null;
        }
    }

    public function putFileData(string $path, string $data): void
    {
        $resource = fopen(sprintf('data://text/plain,%s', $data), 'r');
        $this->bucket->upload($resource, [
            'name' => $path,
        ]);
    }
}