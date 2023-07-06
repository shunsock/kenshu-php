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

        $image_paths = [];
        $count = 0;
        for ($i = 0; $i < sizeof($user_image->getImageName()); $i++) {
            $folder = $user_image->getImageName()[$i];
            $image_paths[$i] = $folder;
            $count++;
        }

        // check if the form is filled
        if ($req->getPostData()["title"] === "" && $req->getPostData()["body"] === "") {
            $html = new CreateBadRequestHtml();
            return new Response(status_code: "403", body: $html->getHtml());
        }

        try {
            $title = $req->getPostData()["title"];
            $body = $req->getPostData()["body"];

            // insert data into the database
            RepositoryPostNewPost::commit(
                title: $title
                , body: $body
                , image_paths: $image_paths
            );

            // move images to the folder
            $count = 0;
            for ($i = 0; $i < count($user_image->getImageBase()); $i++) {
                $tmp_image_location = $user_image->getImageTmpName()[$i];
                $target_image_location = "/var/www/html/public/Image/" . $user_image->getImageName()[$i];
                move_uploaded_file($tmp_image_location,  $target_image_location);
                $count++;
            }

            // redirect to the home page
            $html = "投稿が完了しました。";
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