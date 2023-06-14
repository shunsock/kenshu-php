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

class HandlerTopPage implements HandlerInterface
{
    public function run(Request $req): Response
    {
        if ($req->getRequestMethod() === "GET") {
            $posts = RepositoryGetAllPost::getAllPosts();
            $html = $this->render($posts);
            return new Response(status_code: '200', body: $html);
        } else if ($req->getRequestMethod() === "POST") {
            if ($req->getPostData()["title"] !== "" && $req->getPostData()["body"] !== "") {
                $title = $req->getPostData()["title"];
                $body = $req->getPostData()["body"];
                RepositoryPostNewPost::postNewPost($title, $body);
                $posts = RepositoryGetAllPost::getAllPosts();
                $html = $this->render($posts);
                return new Response(status_code: '200', body: $html);
            } else {
                echo '<p class="my-10 px-5 py-3 rounded-lg bg-monokaiRed text-monokaiWhite">ERROR: Please Enter Both of Title and Post</p>';
                $posts = RepositoryGetAllPost::getAllPosts();
                $html = $this->render($posts);
                return new Response(status_code: '200', body: $html);
            }
        } else {
            return new Response(status_code: '405', body: 'Method Not Allowed');
        }
    }

    private function getPosts(): PostCollection
    {
        return PostMock::getPostCollection();
    }

    private function createBody(PostCollection $posts): string
    {
        $body = '<body>';
        foreach ($posts as $post) {
            $body .= '<div class="my-16 bg-slate-800 p-10 rounded-xl">';
            $body .= '<a href="/post?id=' . $post->getId() . '">';
            $body .= '<h2 class="text-3xl text-monokaiGreen"><span class="text-monokaiRed">Title: </span>' . $post->getTitle() . '</h2>';
            $body .= '<p class="text-monokaiYellow"><span class="text-monokaiOrange">Created_At: </span>' . $post->getCreatedAt() . '</p>';
            $body .= '<img class="my-4 object-contain rounded-xl" src=' . $post->getThumbnail() . ' alt="image">';
            $body .= '<p class="text-md text-monokaiWhite">' . substr(string: $post->getBody(), offset: 0, length: 100) . '...</p>';
            $body .= '</a>';
            $body .= '</div>';
        }
        $body .= '</body>';
        return $body;
    }

    private function render(PostCollection $posts): string
    {
        $body = $this->createBody($posts);
        $html = new CreateHtml($body);
        return $html->getHtml();
    }
}