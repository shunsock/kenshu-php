<?php

declare(strict_types=1);

namespace App\Handler;

use App\Core\Response;

class HandlerImage
{
    public static function run(): Response
    {
        $image_path = $_SESSION['user_image'];
        header(header: 'Content-Type: image/jpeg');
        readfile(filename: $image_path);
        return new Response();
    }
}