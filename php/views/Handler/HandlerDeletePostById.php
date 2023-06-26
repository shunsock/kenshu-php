<?php

declare(strict_types=1);

namespace App\Handler;

use App\Core\RedirectTarget;
use App\Core\Request;
use App\Core\Response;
use App\Html\CreateInternalServerErrorHtml;
use App\Repository\RepositoryDeletePostById;
use PDOException;

class HandlerDeletePost
{
    public static function run(Request $req): Response
    {
        try {
            $id = $req->getParam()['id'];
            RepositoryDeletePostById::deletePost($id);
            $html = "ok, redirect to top page";
            return new Response(
                status_code: "301"
                , body: $html
                , redirect_location: RedirectTarget::getHomePath()
            );
        } catch (PDOException) {
            $html = new CreateInternalServerErrorHtml();
            return new Response(
                status_code: "500"
                , body: $html->getHtml()
            );
        }
    }
}