<?php

declare(strict_types=1);

namespace App\Handler;

use App\Core\Response;
use App\Html\CreateNotFoundHtml;

class HandlerNotFound
{
    public static function run(): Response
    {
        $html = new CreateNotFoundHtml();
        return new Response(status_code: "404", body: $html->getHtml());
    }
}