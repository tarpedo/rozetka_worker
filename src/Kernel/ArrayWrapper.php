<?php

namespace App\Kernel;

/** @psalm-suppress MissingTemplateParam */
class ArrayWrapper extends \Arrayy\Arrayy
{
    protected $pathSeparator = '/';
}