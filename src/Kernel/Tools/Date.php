<?php

declare(strict_types=1);

namespace App\Kernel\Tools;

class Date
{
    public static function createCurrent(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
    }

    public static function createFromString(string $dateAsString, string $format): \DateTimeImmutable
    {
        $datetime = \DateTimeImmutable::createFromFormat($format, $dateAsString, new \DateTimeZone('UTC'));

        if ($datetime === false) {
            throw new \InvalidArgumentException('Failed create DateTimeImmutable from string');
        }

        return $datetime;
    }
}
