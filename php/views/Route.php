<?php

declare(strict_types=1);

namespace App;

use App\Core\Request;
use App\Core\Response;
use App\Handler\HandlerTopPage;

class Route
{
    public static function getHandler(Request $req): Response
    {
        $tmp = new HandlerTopPage();
        return $tmp->run($req);
    }
}

