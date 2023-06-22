<?php

declare(strict_types=1);

namespace App\Handler;
use App\Core\Request;
use App\Core\Response;
use App\Core\RedirectTarget;

class HandlerLogout implements HandlerInterface
{
    // TODO: after implementation of authentication, change router to redirect to login page
    public static function run(Request $req): Response
    {
        unset($_SESSION['user_id']);
        return new Response(
            status_code: "301"
            , body: "ok, redirect to login page"
            , redirect_location: RedirectTarget::getLoginPath()
        );
    }
}