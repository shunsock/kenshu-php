<?php

declare(strict_types=1);

namespace App\Handler;

use App\Core\RedirectTarget;
use App\Core\Request;
use App\Core\Response;

class HandlerLogout implements HandlerInterface
{
    public static function run(Request $req): Response
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_image']);
        return new Response(
            status_code: "301"
            , body: "ok, redirect to login page"
            , redirect_location: RedirectTarget::getLoginPath()
        );
    }
}