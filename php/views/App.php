<?php
declare(strict_types=1);

namespace App;

use App\Core\Request;
use App\Core\Response;

class App
{
    public function run(): void
    {
        $req = new Request(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI'],
            $_GET,
            $_POST
        );
        if ($req->getPath() === "/") {
            $res = Route::getHandler($req);
        } else {
            $res = new Response(status_code: "404", body: "Not Found");
        }
        echo $res->getBody();
    }
}
