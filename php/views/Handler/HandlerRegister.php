<?php
declare(strict_types=1);

namespace App\Handler;

use App\Core\RedirectTarget;
use App\Core\Request;
use App\Core\Response;
use App\Html\CreateInternalServerErrorHtml;
use App\Repository\RepositoryRegister;
use InvalidArgumentException;
use PDOException;

class HandlerRegister
{
    public static function run(Request $req): Response
    {
        if (self::isFormFilled(req: $req) === false) {
            $html = "空欄があります。全て入力してから送信してください。";
            return new Response(
                status_code: "400"
                , body: $html
                , redirect_location: RedirectTarget::getRegisterPath()
            );
        }
        return self::requestDB(req: $req);
    }

    private static function isFormFilled(Request $req): bool
    {
        if ($req->getPostData()["username"] !== "" && $req->getPostData()["password"] !== "") {
            return true;
        } else {
            return false;
        }

    }

    private static function requestDB(Request $req): Response
    {
        try {
            $username = $req->getPostData()["username"];
            $email = $req->getPostData()["email"];
            $password_hashed = password_hash($req->getPostData()["password"], algo: PASSWORD_DEFAULT);
            RepositoryRegister::commit(
                user_name: $username
                , email: $email
                , password_hashed: $password_hashed
            );
            $html = "ok, redirect to top page";
            return new Response(
                status_code: "301"
                , body: $html
                , redirect_location: RedirectTarget::getHomePath()
            );
        } catch (PDOException) {
            // ERROR from System
            $html = new CreateInternalServerErrorHtml();
            return new Response(status_code: "500", body: $html->getHtml());
        } catch (InvalidArgumentException) {
            // ERROR from User Input
            $html = "この名前は登録できません。すでに登録されています。";
            return new Response(
                status_code: "400"
                , body: $html
                , redirect_location: RedirectTarget::getRegisterPath()
            );
        }
    }
}