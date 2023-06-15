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
use PDO;

class Route
{
    public static function getHandler(Request $req): Response
    {
        if ($req->getUri() === "/" && $req->getRequestMethod() === "GET") {
            // GET REQUEST: Top Page
            $tmp = new HandlerTopPage();
        } else if ( $req->getUri() === '/'  && $req->getRequestMethod() === "POST") {
            // POST REQUEST: New Post
            $tmp = new HandlerPostNewPost();
            try {
                $tmp->run(req: $req);
                header(header: "localhost:8080/", response_code: 301);
                $tmp = new HandlerTopPage();
            } catch (InvalidArgumentException $e) {
                throw PDO::Exception(message: 'SQL Processing Failed: ' . $e->getMessage() . '');
            }
        } else if (str_contains($req->getUri(), '/post') && $req->getRequestMethod() === "GET") {
            $tmp = new HandlerPostPage();
        } else if (str_contains($req->getUri(), '/post') && $req->getPostData()["_method"] === "delete") {
            // DELETE REQUEST: Delete Post
            $tmp = new HandlerDeletePost();
            try {
                $tmp->run(req: $req);
                header(header: "localhost:8080/", response_code: 301);
                $tmp = new HandlerTopPage();
            } catch (InvalidArgumentException $e) {
                throw PDO::Exception(message: 'SQL Processing Failed: ' . $e->getMessage() . '');
            }
        } else {
            throw new InvalidArgumentException(message: 'Invalid URI');
        }
        return $tmp->run(req: $req);
    }
}