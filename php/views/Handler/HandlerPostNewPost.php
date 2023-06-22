<?php
declare(strict_types=1);

namespace App\Handler;

use App\Core\RedirectTarget;
use App\Core\Request;
use App\Core\Response;
use App\Html\CreateBadRequestHtml;
use App\Html\CreateInternalServerErrorHtml;
use App\Repository\RepositoryPostNewPost;
use PDOException;

class HandlerPostNewPost
{
    public static function run(Request $req): Response
    {
        if ($req->getPostData()["title"] !== "" && $req->getPostData()["body"] !== "") {
            try {
                $title = $req->getPostData()["title"];
                $body = $req->getPostData()["body"];
                RepositoryPostNewPost::postNewPost($title, $body);
                $html = "ok, redirect to top page";
                return new Response(
                    status_code: "301"
                    , body: $html
                    , redirect_location: RedirectTarget::getHomePath()
                );
            } catch (PDOException) {
                $html = new CreateInternalServerErrorHtml();
                return new Response(status_code: "500", body: $html->getHtml());
            }
        } else {
            $html = new CreateBadRequestHtml();
            return new Response(status_code: "403", body: $html->getHtml());
        }
    }
}