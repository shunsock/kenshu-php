<?php

declare(strict_types=1);

namespace App;

use App\Core\Request;
use App\Core\Response;
use App\Handler\HandlerTopPage;
use App\Handler\HandlerPostPage;
class Route
{
    public static function getHandler(Request $req): Response
    {
        if ($req->getUri() === "/") {
            $tmp = new HandlerTopPage();
        } else if (preg_match('/\/(\?id=)[0-9]+/', $req->getUri())) {
            $tmp = new HandlerPostPage();
        } else {
            throw new \InvalidArgumentException(message: 'Invalid URI');
        }
        return $tmp->run($req);
    }
}