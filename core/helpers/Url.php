<?php

namespace dwes\core\helpers;
class Url
{
    private static ?string $base = null;

    public static function base(): string
    {
        if (self::$base === null) {
            self::$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        }
        return self::$base;
    }

    public static function to(string $path = ''): string
    {
        return self::base() . '/' . ltrim($path, '/');
    }
}
