<?php

declare(strict_types=1);

namespace App\Kernel\FileStorage\Engine;

use Google\Cloud\Storage\StorageClient;

class GoogleFactory
{
    public function create(string $googleAppKeyfile, string $googleStorageBucket): \App\Kernel\FileStorage\Engine\Google
    {
        $storage = new StorageClient(['keyFilePath' => $googleAppKeyfile]);
        $bucket = $storage->bucket($googleStorageBucket);

        return new \App\Kernel\FileStorage\Engine\Google($bucket);
    }
}