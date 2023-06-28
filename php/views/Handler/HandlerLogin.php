<?php

declare(strict_types=1);

namespace App\Handler;

use App\Core\RedirectTarget;
use App\Core\Request;
use App\Core\Response;
use App\Repository\RepositoryGetUserByName;
use InvalidArgumentException;
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

        // username and password are set, so we can try to get the user
        try {
            // Collection of User
            $user = RepositoryGetUserByName::getData(
                $req->getPostData()["username"]
            );

            if ($user->checkPassword($req->getPostData()["password"]) === false) {
                return new Response(
                    status_code: "401"
                    , body: "Unauthorized"
                    , redirect_location: RedirectTarget::getLoginPath()
                );
            }

            // Login successful
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user_name'] = $user->getName();
            return new Response(
                status_code: "301"
                , body: "ok, redirect to home page"
                , redirect_location: RedirectTarget::getHomePath()
            );

        } catch (PDOException) {
            // if SQL error, return 500
            return new Response(
                status_code: "500",
                body: "Internal Server Error"
            );
        } catch (InvalidArgumentException) {
            // if user does not exist, return 401
            return new Response(
                status_code: "401"
                , body: "Unauthorized"
                , redirect_location: RedirectTarget::getLoginPath()
            );
        }
    }
}