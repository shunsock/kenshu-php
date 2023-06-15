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
        $posts = RepositoryGetAllPost::getAllPosts();
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
            $body .= '<a href="/post?id=' . $post->getId() . '">';
            $body .= '<h2 class="text-3xl text-monokaiGreen"><span class="text-monokaiRed">Title: </span>' . $post->getTitle() . '</h2>';
            $body .= '<p class="text-monokaiYellow"><span class="text-monokaiOrange">Created_At: </span>' . $post->getCreatedAt() . '</p>';
            $body .= '<img class="my-4 object-contain rounded-xl" src=' . $post->getThumbnail() . ' alt="image">';
            $body .= '<p class="text-md text-monokaiWhite">' . substr(string: $post->getBody(), offset: 0, length: 100) . '...</p>';
            $body .= '</a>';
            $body .= '</div>';
        }
        $body .= $this->getForm();
        $body .= '</body>';
        return $body;
    }
    private function getForm(): string
    {
        $form = '<form action="/" method="POST" >';
        $form .= '<h2 class="text-3xl text-monokaiWhite">Create New Post</h2>';
        $form .= '<input type="text" name="title"  placeholder="Enter Title" class="text-slate-800 h-20 w-full rounded-lg bg-monokaiWhite px-16 py-5 my-5">';
        $form .= '<textarea name="body" placeholder="Enter Body" class="text-slate-800 h-96 w-full rounded-lg bg-monokaiWhite px-16 py-5"></textarea>';
        $form .= '<div class="rounded-lg p-3 w-36 bg-slate-500 hover:bg-monokaiBlue text-center my-5">';
        $form .= '<input type="submit" value="Submit" class="text-xl">';
        $form .= '</div>';
        $form .= '</form>';
        return $form;
    }

    private function render(PostCollection $posts): string
    {
        $body = $this->createBody($posts);
        $html = new CreateHtml($body);
        return $html->getHtml();
    }
}
