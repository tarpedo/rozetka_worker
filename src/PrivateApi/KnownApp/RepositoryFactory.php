<?php

namespace App\PrivateApi\KnownApp;

class RepositoryFactory
{
    public function __construct(private readonly array $rawApplications)
    {
    }

    public function create(): Repository
    {
        $apps = [];
        foreach ($this->rawApplications as ['name' => $name, 'key' => $key]) {
            $apps[] = new \App\PrivateApi\KnownApp($name, $key);
        }

        return new Repository($apps);
    }
}