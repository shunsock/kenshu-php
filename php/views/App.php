<?php
declare(strict_types=1);
namespace App;
use App\Core\Request;


class App
{
    public function run()
    {
        #$handler = Route::getHandler($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
        $req = new Request(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI'],
            $_GET,
            $_POST
        );
        echo var_dump($req);

        //$res = $handler->run($req);

        // http_response_code($res['status_code']);
        // header('Content-Type: text/html; charset=utf-8');
        // echo $res['body'];
        echo var_dump($req);
    }
}
