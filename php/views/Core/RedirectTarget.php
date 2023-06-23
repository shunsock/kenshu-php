<?php
declare(strict_types=1);

namespace App\Core;

class RedirectTarget
{
    private const HOME_PATH = "/";
    private const LOGIN_PATH = "/login";
    private const REGISTER_PATH = "/register";

    public static function getHomePath(): string
    {
        return self::HOME_PATH;
    }

    public static function getLoginPath(): string
    {
        return self::LOGIN_PATH;
    }

    public static function getRegisterPath(): string
    {
        return self::REGISTER_PATH;
    }
}