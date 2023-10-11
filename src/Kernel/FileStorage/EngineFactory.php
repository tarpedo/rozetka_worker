<?php

declare(strict_types=1);

namespace App\Kernel\FileStorage;

class EngineFactory
{
    private const ENGINE_TYPE_LOCAL = 'local';

    public function __construct(
        private readonly string $engine,
        private readonly Engine\LocalFactory $localFactory,
        private readonly \App\Kernel\FoldersStructure $foldersStructure,
    ) {
    }

    public function create(): EngineInterface
    {
        if ($this->engine === self::ENGINE_TYPE_LOCAL) {
            return $this->localFactory->create(
                $this->foldersStructure->getVarPath() . 'file_storage/'
            );
        }

        throw new \LogicException('Undefined storage type');
    }
}