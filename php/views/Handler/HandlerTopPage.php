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
            $body .= '<div>';
            $body .= '<h2>' . $post->getTitle() . '</h2>';
            $body .= '<p>' . $post->getCreatedAt() . '</p>';
            $body .= '<p>' . $post->getBody() . '</p>';
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