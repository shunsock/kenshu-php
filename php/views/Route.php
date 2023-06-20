<?php

declare(strict_types=1);

namespace App;

use App\Core\Request;
use App\Core\Response;
use App\Handler\HandlerLoginPage;
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
        // if user does not have authentication information, redirect to login page
        $res = self::routingByRequestAndUri($req);

        if ($res->getStatusCode() === "301") {
            header(header: "Location: http://localhost:8080/");
            $res = HandlerTopPage::run($req);
            return $res;
        } else {
            return $res;
        }
    }

    private static function routingByRequestAndUri(Request $req): Response
    {
        $uri = $req->getUri();
        $method = $req->getRequestMethod();
        if ($uri === "/login" && $method ==="GET"){
            $res = HandlerLoginPage::run($req);
//        } else if ($uri === "/login" && $method === "POST") {
//            $res = HandlerLogin::run($req);
//        } else if ($uri === "/logout" && $method === "POST") {
//            $res = HandlerLogout::run($req);
        } else if ($uri === "/" && $method === "GET") {
            $res = HandlerTopPage::run($req);
        } else if ($uri === "/" && $method === "POST") {
            $res = HandlerPostNewPost::run($req);
        } else if (str_contains($uri, '/post') && $method === "GET") {
            $res = HandlerPostPage::run($req);
        } else if (str_contains($uri, '/post') && $req->getPostData()["_method"] === "delete") {
            $res = HandlerDeletePost::run($req);
        } else if (str_contains($uri, '/edit') && $method === "GET") {
            $res = HandlerEditPost::run($req);
        } else if (str_contains($uri, '/edit') && $req->getPostData()["_method"] === "put") {
            $res = HandlerUpdatePost::run($req);
        } else {
            $res = HandlerNotFound::run();
        }
        return $res;
    }
}