<?php

declare(strict_types=1);

namespace App\Handler;

use App\Core\Request;
use App\Core\Response;
use App\Html\CreateInternalServerErrorHtml;
use App\Repository\RepositoryDeletePost;
use PDOException;

class HandlerDeletePost
{
    public static function run(Request $req): Response
    {
        try {
            $id = $req->getParam()['id'];
            RepositoryDeletePost::deletePost($id);
            $html = "ok, redirect to top page";
            return new Response(status_code: "301", body: $html);
        } catch (PDOException) {
            $html = new CreateInternalServerErrorHtml();
            return new Response(status_code: "301", body: $html->getHtml());
        }
    }
}