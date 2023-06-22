<?php
declare(strict_types=1);

namespace App\Core;

class RedirectTarget
{
    private const HOME_PATH = "/";
    private const LOGIN_PATH = "/login";

    public static function getHomePath(): string
    {
        return self::HOME_PATH;
    }

    public static function getLoginPath(): string
    {
        return self::LOGIN_PATH;
    }
}