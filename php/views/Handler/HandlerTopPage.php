<?php
declare(strict_types=1);

namespace App\Handler;

use App\Core\Request;
use App\Core\Response;
use App\Html\CreateInternalServerErrorHtml;
use App\Html\CreateTopPageHtml;
use App\Repository\RepositoryGetAllPost;
use PDOException;

class HandlerTopPage implements HandlerInterface
{
    public static function run(Request $req): Response
    {
        // repositoryが例外を投げるのでここでtry catch
        try {
            $posts = RepositoryGetAllPost::getData();
            $html = new CreateTopPageHtml($posts);
            return new Response(status_code: '200', body: $html->getHtml());
        } catch (PDOException) {
            $html = new CreateInternalServerErrorHtml();
            return new Response(status_code: '500', body: $html->getHtml());
        }
    }
}