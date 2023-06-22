<?php
declare(strict_types=1);

namespace App\Handler;

use App\Core\Request;
use App\Core\Response;
use App\Core\RedirectTarget;
use App\Repository\RepositoryRegister;
use App\Html\CreateInternalServerErrorHtml;
use App\Html\CreateBadRequestHtml;
use PDOException;

class HandlerRegister
{
    public static function run(Request $req): Response
    {
        if ($req->getPostData()["username"] !== "" && $req->getPostData()["password"] !== "") {
            try {
                $username = $req->getPostData()["username"];
                $email = $req->getPostData()["email"];
                $password_hashed = password_hash($req->getPostData()["password"], PASSWORD_DEFAULT);
                RepositoryRegister::RegisterUser(
                    user_name: $username
                    , email: $email
                    , password_hashed: $password_hashed
                );
                $html = "ok, redirect to top page";
                return new Response(
                    status_code: "301"
                    , body: $html
                    ,redirect_location: RedirectTarget::getHomePath()
                );
            } catch (PDOException) {
                $html = new CreateInternalServerErrorHtml();
                return new Response(status_code: "500", body: $html->getHtml());
            }
        } else {
            $html =  new CreateBadRequestHtml();
            return new Response(status_code: "403", body: $html->getHtml());
        }
    }
}