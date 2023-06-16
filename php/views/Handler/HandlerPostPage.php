<?php

declare(strict_types=1);

namespace App\Handler;

use App\Core\Request;
use App\Core\Response;
use App\Html\CreatePostPageHtml;
use App\Html\CreateInternalServerErrorHtml;
use App\Repository\RepositoryGetPostById;
use PDOException;

class HandlerPostPage implements HandlerInterface
{

    public static function run(Request $req): Response
    {
        $id = $req->getParam()['id'];
        try {
            $posts = RepositoryGetPostById::getPostById(id: $id);
            $html = new CreatePostPageHtml($posts);
            return new Response(status_code: '200', body: $html->getHtml());
        } catch (PDOException) {
            $html = new CreateInternalServerErrorHtml();
            return new Response(status_code: '500', body: $html->getHtml());
        }
    }
}