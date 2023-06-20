<?php

declare(strict_types=1);

namespace App\Handler;
use App\Core\Request;
use App\Core\Response;
use App\Repository\RepositoryGetUserByName;
use PDOException;

class HandlerLogin implements HandlerInterface
{
    public static function run(Request $req): Response
    {
        // Check if username and password are set
        if (isset($req->getPostData()["username"]) === false || isset($req->getPostData()["password"]) === false) {
            return new Response(
                status_code: "400",
                body: "Bad Request"
            );
        }

        // username and password are set so we can try to get the user
        try {
            // Collection of User
            $users = RepositoryGetUserByName::getUserByName(
                $req->getPostData()["username"]
            );

            if ($users->checkPassword($req->getPostData()["password"]) === false) {
                return new Response(
                    status_code: "401",
                    body: "Unauthorized"
                );
            }
            return new Response(
                status_code: "301",
                body: "ok, redirect to home page"
            );
        } catch (PDOException) {
            return new Response(
                status_code: "500",
                body: "Internal Server Error"
            );
        }
    }
}