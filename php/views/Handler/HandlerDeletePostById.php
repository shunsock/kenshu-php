<?php

declare(strict_types=1);

namespace App\Handler;

use App\Core\RedirectTarget;
use App\Core\Request;
use App\Core\Response;
use App\Html\CreateInternalServerErrorHtml;
use App\Repository\RepositoryDeletePostById;
use OutOfBoundsException as OutOfBoundsExceptionAlias;
use PDOException;

class HandlerDeletePostById
{
    public static function run(Request $req): Response
    {
        try {
            $id = $req->getParam()['id'];
            RepositoryDeletePostById::commit($id);
            $html = "ok, redirect to top page";
            return new Response(
                status_code: "301"
                , body: $html
                , redirect_location: RedirectTarget::getHomePath()
            );
        } catch (PDOException|OutOfBoundsExceptionAlias) {
            $html = new CreateInternalServerErrorHtml();
            return new Response(
                status_code: "500"
                , body: $html->getHtml()
            );
        }
    }
}