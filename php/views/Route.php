<?php

declare(strict_types=1);

namespace App;

use App\Core\Request;
use App\Core\Response;
use App\Handler\HandlerTopPage;
use App\Handler\HandlerPostPage;
use App\Handler\HandlerPostNewPost;
use App\Handler\HandlerDeletePost;
use App\Handler\HandlerEditPost;
use App\Handler\HandlerUpdatePost;
use App\Handler\HandlerNotFound;

class Route
{
    public static function getHandler(Request $req): Response
    {
        if ($req->getUri() === "/" && $req->getRequestMethod() === "GET") {
            // GET REQUEST: Top Page
            $res = HandlerTopPage::run($req);
        } else if ( $req->getUri() === '/'  && $req->getRequestMethod() === "POST") {
            // POST REQUEST: New Post
            $res = HandlerPostNewPost::run($req);
        } else if (str_contains($req->getUri(), '/post') && $req->getRequestMethod() === "GET") {
            $res = HandlerPostPage::run($req);
        } else if (str_contains($req->getUri(), '/post') && $req->getPostData()["_method"] === "delete") {
            // DELETE REQUEST: Delete Post
            $res = HandlerDeletePost::run($req);
        } else if (str_contains($req->getUri(), '/edit') && $req->getRequestMethod() === "GET") {
            // GET REQUEST: Editor
            $res = HandlerEditPost::run($req);
        } else if (str_contains($req->getUri(), '/edit') && $req->getPostData()["_method"] === "put") {
            // PUT REQUEST: Edit Post
            $res = HandlerUpdatePost::run($req);
        } else {
            var_dump($req);
            $res = HandlerNotFound::run();
        }

        if ($res->getStatusCode() === "301") {
            header(header: "Location: http://localhost:8080/");
            $res = HandlerTopPage::run($req);
        }

        return $res;
    }
}