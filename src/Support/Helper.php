<?php

declare(strict_types=1);

namespace MyApp\Support;

class Helper
{
    public static function toString($value): string
    {
        return strval($value);
    }

    public static function getDateFormat(string $date, string $format): string
    {
        return date($format, strtotime($date));
    }
}
