<?php

declare(strict_types=1);

namespace App;

use App\Core\RedirectTarget;
use App\Core\Request;
use App\Core\Response;
use App\Handler\HandlerDeletePost;
use App\Handler\HandlerEditPost;
use App\Handler\HandlerLogin;
use App\Handler\HandlerLoginPage;
use App\Handler\HandlerLogout;
use App\Handler\HandlerNotAuthor;
use App\Handler\HandlerNotFound;
use App\Handler\HandlerPostNewPost;
use App\Handler\HandlerPostPage;
use App\Handler\HandlerRegister;
use App\Handler\HandlerRegisterPage;
use App\Handler\HandlerTopPage;
use App\Handler\HandlerUpdatePost;

class Route
{
    public static function getHandler(Request $req): Response
    {
        // if user does not have authentication information, redirect to login page
        session_start();
        self::routeLoginPageIfNotLoggedIn(req: $req);
        $res = self::routingByUriAndMethod($req);

        self::redirect(res: $res);

        return $res;

    }

    private static function routeLoginPageIfNotLoggedIn(Request $req): void
    {
        $allowedPath = [
            "/login",
            "/register"
        ];
        if (empty($_SESSION['user_name']) && in_array(needle: $req->getUri(), haystack: $allowedPath) === false) {
            header(header: "Location: http://localhost:8080/login");
            exit();
        }
    }

    private static function routingByUriAndMethod(Request $req): Response
    {
        $uri = $req->getUri();
        $method = $req->getRequestMethod();
        if ($uri === "/" && $method === "GET") {
            $res = HandlerTopPage::run($req);
        } else if ($uri === "/" && $method === "POST") {
            $res = HandlerPostNewPost::run($req);
        } else if ($uri === "/login" && $method === "GET") {
            $res = HandlerLoginPage::run($req);
        } else if ($uri === "/login" && $method === "POST") {
            $res = HandlerLogin::run($req);
        } else if ($uri === "/logout" && $method === "GET") {
            $res = HandlerLogout::run($req);
        } else if ($uri === "/not-author") {
            $res = HandlerNotAuthor::run($req);
        } else if ($uri === '/register' && $method === "GET") {
            $res = HandlerRegisterPage::run($req);
        } else if ($uri === '/register' && $method === "POST") {
            $res = HandlerRegister::run($req);
        } else if (str_contains($uri, '/edit') && $method === "GET") {
            $res = HandlerEditPost::run($req);
        } else if (str_contains($uri, '/edit') && $req->getPostData()["_method"] === "put") {
            $res = HandlerUpdatePost::run($req);
        } else if (str_contains($uri, '/post') && $method === "GET") {
            $res = HandlerPostPage::run($req);
        } else if (str_contains($uri, '/post') && $req->getPostData()["_method"] === "delete") {
            $res = HandlerDeletePost::run($req);
        } else {
            $res = HandlerNotFound::run();
        }

        return $res;
    }

    private static function redirect(Response $res): void
    {
        if ($res->getStatusCode() === "301" && $res->getRedirectLocation() === RedirectTarget::getLoginPath()) {
            header(header: "Location: http://localhost:8080/login", response_code: 301);
            exit();
        } else if ($res->getStatusCode() === "301" && $res->getRedirectLocation() === RedirectTarget::getHomePath()) {
            header(header: "Location: http://localhost:8080/", response_code: 301);
            exit();
        } else if ($res->getStatusCode() === "401" && $res->getRedirectLocation() === RedirectTarget::getLoginPath()) {
            header(header: "Location: http://localhost:8080/login");
            exit();
        } elseif ($res->getStatusCode() === "400" && $res->getRedirectLocation() === RedirectTarget::getRegisterPath()) {
            $_SESSION["message"] = $res->getBody();
            header(header: "Location: http://localhost:8080/register");
            exit();
        }
    }
}