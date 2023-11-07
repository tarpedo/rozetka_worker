<?php

namespace App\PrivateApi\KnownApp;

class Repository
{
    /**
     * @param \App\PrivateApi\KnownApp[] $applications
     */
    public function __construct(private readonly array $applications)
    {
    }

    public function hasApplication(string $name): bool
    {
        return $this->findApplication($name) !== null;
    }

    public function getApplication(string $name): \App\PrivateApi\KnownApp
    {
        /** @var \App\PrivateApi\KnownApp */
        return $this->findApplication($name);
    }

    public function findApplication(string $name): ?\App\PrivateApi\KnownApp
    {
        foreach ($this->applications as $application) {
            if ($application->name === $name) {
                return $application;
            }
        }

        return null;
    }
}