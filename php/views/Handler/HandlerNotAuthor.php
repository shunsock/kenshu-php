<?php

declare(strict_types=1);

namespace App\Handler;

use App\Core\Request;
use App\Core\Response;
use App\Core\RedirectTarget;
use App\Html\CreateBadRequestHtml;

class HandlerNotAuthor implements HandlerInterface
{
    public static function run(Request $req): Response
    {
        $html = new CreateBadRequestHtml();
        return new Response(
            status_code: "403"
            , body: $html->getHtml()
        );
    }
}