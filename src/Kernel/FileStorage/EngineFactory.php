<?php

declare(strict_types=1);

namespace App\Kernel\FileStorage;

class EngineFactory
{
    private const ENGINE_TYPE_LOCAL = 'local';
    private const ENGINE_TYPE_GOOGLE = 'google';

    public function __construct(
        private readonly string $engine,
        private readonly string $googleAppKeyfile,
        private readonly string $googleStorageBucket,
        private readonly Engine\LocalFactory $localFactory,
        private readonly Engine\GoogleFactory $googleFactory,
        private readonly \App\Kernel\FoldersStructure $foldersStructure,
    ) {
    }

    public function create(): EngineInterface
    {
        if ($this->engine === self::ENGINE_TYPE_LOCAL) {
            return $this->localFactory->create(
                $this->foldersStructure->getVarPath().'file_storage/'
            );
        }

        if ($this->engine === self::ENGINE_TYPE_GOOGLE) {
            return $this->googleFactory->create(
                $this->foldersStructure->getRootDir().$this->googleAppKeyfile,
                $this->googleStorageBucket
            );
        }

        throw new \LogicException('Undefined storage type');
    }
}