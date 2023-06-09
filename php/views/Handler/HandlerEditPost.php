<?php

declare(strict_types=1);

namespace App\Handler;

use App\Core\Request;
use App\Core\Response;
use App\Html\CreateEditPageHtml;
use App\Html\CreateInternalServerErrorHtml;
use App\Html\CreateNotFoundHtml;
use App\Repository\RepositoryGetPostById;
use PDOException;

class HandlerEditPost implements HandlerInterface
{
    public static function run(Request $req): Response
    {
        // idが存在しない場合は404を返す
        if ($req->doesPostIdExist()) {
            $id = $req->getPostId();
        } else {
            $html = new CreateNotFoundHtml();
            return new Response(status_code: '404', body: $html->getHtml());
        }

        // idが存在する場合は、idに紐づく記事を取得する
        try {
            $posts = RepositoryGetPostById::getData(id: $id);
            $id = $posts->getId();
            $title = $posts->getTitle();
            $body = $posts->getBody();
            $html = new CreateEditPageHtml(id: $id, title: $title, body: $body);
            return new Response(status_code: '200', body: $html->getHtml());
        } catch (PDOException) {
            $html = new CreateInternalServerErrorHtml();
            return new Response(status_code: '500', body: $html->getHtml());
        }
    }
}