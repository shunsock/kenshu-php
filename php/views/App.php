<?php
declare(strict_types=1);

namespace App;

use App\Core\Request;

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
        $res = Route::getHandler($req);
        echo $res->getBody();
    }
}
