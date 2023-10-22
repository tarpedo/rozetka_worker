<?php

declare(strict_types=1);

namespace App\ThirdParty\RozetkaApi;

interface ConnectorInterface
{
    public function single(Account $account, CommandInterface $command): \App\Kernel\ArrayWrapper;
}