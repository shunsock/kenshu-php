<?php

declare(strict_types=1);

namespace App;

use App\Core\Request;
use App\Core\Response;
use App\Handler\HandlerTopPage;
use App\Handler\HandlerPostPage;
use App\Handler\HandlerPostNewPost;
use App\Handler\HandlerDeletePost;
use InvalidArgumentException;

class Route
{
    public static function getHandler(Request $req): Response
    {
        if ($req->getUri() === "/" && $req->getRequestMethod() === "GET") {
            $tmp = new HandlerTopPage();
        } else if (str_contains($req->getUri(), '/')  && $req->getRequestMethod() === "POST") {
            $tmp = new HandlerPostNewPost();
            $tmp->run(req: $req);
            header(header: "localhost:8080/", response_code: 301);
            $tmp = new HandlerTopPage();
        } else if (str_contains($req->getUri(), '/post') && $req->getRequestMethod() === "GET") {
            $tmp = new HandlerPostPage();
        } else if (str_contains($req->getUri(), '/post') && $req->getPostData()["_method"] === "delete") {
            $tmp = new HandlerDeletePost();
            $tmp->run(req: $req);
            header(header: "localhost:8080/", response_code: 301);
            $tmp = new HandlerTopPage();
        } else {
            throw new InvalidArgumentException(message: 'Invalid URI');
        }
        return $tmp->run(req: $req);
    }
}