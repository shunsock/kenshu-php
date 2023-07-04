<?php
declare(strict_types=1);

namespace App\Handler;

use App\Core\RedirectTarget;
use App\Core\Request;
use App\Core\Response;
use App\Core\UploadedImageChecker;
use App\Html\CreateInternalServerErrorHtml;
use App\Repository\RepositoryRegister;
use Exception;
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
        try {
            $user_image = new UploadedImageChecker();
            $image_name = $req->getPostData()["username"]."_".$user_image->getImageName();
        } catch (Exception $e) {
            $html = "画像のアップロードに失敗しました。".$e;
            return new Response(
                status_code: "400"
                , body: $html
                , redirect_location: RedirectTarget::getRegisterPath()
            );
        }

        return self::requestDB(req: $req, image_name: $image_name);
    }

    private static function isFormFilled(Request $req): bool
    {
        if ($req->getPostData()["username"] !== "" && $req->getPostData()["password"] !== "") {
            return true;
        } else {
            return false;
        }

    }

    private static function requestDB(Request $req, string $image_name): Response
    {
        try {
            $username = $req->getPostData()["username"];
            $email = $req->getPostData()["email"];
            $password_hashed = password_hash($req->getPostData()["password"], algo: PASSWORD_DEFAULT);
            RepositoryRegister::commit(
                user_name: $username
                , email: $email
                , image_name: $image_name
                , password_hashed: $password_hashed
            );
            $folder = "/var/www/html/public/Image/" . $image_name;
            move_uploaded_file($_FILES["user-image"]["tmp_name"], $folder);
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
        } catch (InvalidArgumentException $e) {
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