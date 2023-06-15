<?php

declare(strict_types=1);

namespace App\Handler;

use App\Core\Request;
use App\Repository\RepositoryDeletePost;
use PDOException;

class HandlerDeletePost
{
    public function run(Request $req): Response
    {
        try {
            $id = $req->getParam()['id'];
            RepositoryDeletePost::deletePost($id);
            return Response(message: "OK", status_code: 200);
        } catch (PDOException) {
            return Response(message: "Internal Server Error", status_code: 500);
        }
    }
}