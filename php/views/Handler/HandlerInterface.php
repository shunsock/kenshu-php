<?php

namespace App\Handler;

use App\Core\Request;
use App\Core\Response;

interface HandlerInterface
{
    public static function run(Request $req): Response;
}