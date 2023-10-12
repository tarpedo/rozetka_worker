<?php

declare(strict_types=1);

namespace App\Kernel;

class FoldersStructure
{
    public function __construct(
        private readonly string $projectDir,
    ) {
    }

    public function getRootDir(): string
    {
        return rtrim($this->projectDir, '/').'/';
    }

    public function getVarPath(): string
    {
        return $this->getRootDir().'var/';
    }
}