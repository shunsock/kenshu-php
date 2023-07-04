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
use InvalidArgumentException;
use PDOException;

class HandlerPostNewPost
{
    public static function run(Request $req): Response
    {
        // check images
        $image_names = [];
        try {
            $user_image = new UploadedImageChecker();
        } catch (InvalidArgumentException $e) {
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
            RepositoryPostNewPost::commit($title, $body, $image_names);
            $count = 0;
            for ($i = 0; $i < count($user_image->getImageBase()); $i++) {
                $tmp_image_location = $user_image->getImageTmpName()[$i];
                $folder = "/var/www/html/public/Image/" . $_SESSION["user_name"] . "_" . $user_image->getImageName()[$i];
                $count++;
            }
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