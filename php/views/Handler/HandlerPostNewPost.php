<?php
declare(strict_types=1);

namespace App\Handler;

use App\Core\RedirectTarget;
use App\Core\Request;
use App\Core\Response;
use App\Core\UploadedImageChecker;
use App\Html\CreateBadRequestHtml;
use App\Html\CreateInternalServerErrorHtml;
use App\Repository\RepositoryPostNewPost;
use PDOException;

class HandlerPostNewPost
{
    public static function run(Request $req): Response
    {
        // check images
        try {
            var_dump($_FILES);
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

        // check if the form is filled
        if ($req->getPostData()["title"] === "" && $req->getPostData()["body"] === "") {
            $html = new CreateBadRequestHtml();
            return new Response(status_code: "403", body: $html->getHtml());
        }

        try {
            $title = $req->getPostData()["title"];
            $body = $req->getPostData()["body"];
            RepositoryPostNewPost::commit($title, $body);
            $html = "ok, redirect to top page";
            return new Response(
                status_code: "301"
                , body: $html
                , redirect_location: RedirectTarget::getHomePath()
            );
        } catch (PDOException) {
            $html = new CreateInternalServerErrorHtml();
            return new Response(status_code: "500", body: $html->getHtml());
        }
    }
}