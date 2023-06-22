<?php

declare(strict_types=1);

namespace App\Handler;

use App\Core\Request;
use App\Core\Response;
use App\Html\CreateRegisterPageHtml;

class HandlerRegisterPage implements HandlerInterface
{
    public static function run(Request $req): Response {
        $html = new CreateRegisterPageHtml();
        return new Response(status_code: "200", body: $html->getHtml());
    }
}