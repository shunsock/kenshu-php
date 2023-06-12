<?php
declare(strict_types=1);

namespace App\Handler;

use App\Mock\PostMock;
use App\Core\Request;
use App\Core\Response;
use App\Core\CreateHtml;
use App\Model\PostCollection;

class HandlerTopPage implements HandlerInterface
{
    public function run(Request $req): Response
    {
        $posts = $this->getPosts();
        $html = $this->render($posts);
        return new Response(status_code: '200', body: $html);
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
            $body .= '<a href="/?id=' . $post->getId() . '">';
            $body .= '<h2 class="text-3xl text-monokaiGreen"><span class="text-monokaiRed">Title: </span>' . $post->getTitle() . '</h2>';
            $body .= '<p class="text-monokaiYellow"><span class="text-monokaiOrange">Created_At: </span>' . $post->getCreatedAt() . '</p>';
            $body .= '<img class="my-4 object-contain rounded-xl" src=' . $post->getThumbnail() . ' alt="image">';
            $body .= '<p class="text-md text-monokaiWhite">' . substr(string: $post->getBody(), offset: 0, length: 100). '...</p>';
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