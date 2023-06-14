<?php

declare(strict_types=1);

namespace App\Handler;

use App\Core\Request;
use App\Repository\RepositoryDeletePost;

class HandlerDeletePost
{
    public function run(Request $req): void
    {
        $id = $req->getParam()['id'];
        RepositoryDeletePost::deletePost($id);
    }
}