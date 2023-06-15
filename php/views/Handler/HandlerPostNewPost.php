<?php
declare(strict_types=1);

namespace App\Handler;

use App\Mock\PostMock;
use App\Core\Request;
use App\Core\Response;
use App\Core\CreateHtml;
use App\Model\PostCollection;
use App\Repository\RepositoryGetAllPost;
use App\Repository\RepositoryPostNewPost;

class HandlerPostNewPost
{
    public function run(Request $req): void
    {
        if ($req->getPostData()["title"] !== "" && $req->getPostData()["body"] !== "") {
            $title = $req->getPostData()["title"];
            $body = $req->getPostData()["body"];
            RepositoryPostNewPost::postNewPost($title, $body);
        }
    }
}