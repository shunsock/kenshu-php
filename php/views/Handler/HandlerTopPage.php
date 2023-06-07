<?php
declare(strict_types=1);

namespace App\Core;

namespace App\Handler;

use App\Core\Request;
use App\Core\Response;

class HandlerTopPage implements HandlerInterface
{
    public function run(Request $req): Response
    {
        return new Response(status_code: "200", body: "<html><body>Hello World</body></html>");
    }
}