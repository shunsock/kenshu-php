<?php

namespace App\Handler;

use App\Core\Request;
use App\Core\Response;

interface HandlerInterface
{
    public function run(Request $req): Response;
}