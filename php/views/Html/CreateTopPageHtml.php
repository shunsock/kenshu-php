<?php

declare(strict_types=1);

namespace App\Html;

use App\Model\PostCollection;

class CreateTopPageHtml extends HtmlTemplate implements HtmlInterface
{
    private string $html;

    public function __construct(PostCollection $post_collection)
    {
        $html = '<!DOCTYPE html>';
        $html .= '<html lang="jp">';
        $html .= $this->getHead();
        $html .= '<body class="bg-slate-700 text-white px-[30%] my-10">';
        $html .= $this->getHeader();
        $html .= $this->getNavbar();
        $html .= $this->getMain($post_collection);
        $html .= $this->getForm();
        $html .= $this->getFooter();
        $html .= '</body>';
        $html .= '</html>';
        $this->html = $html;
    }


    private function getMain(PostCollection $posts): string
    {
        $main = '<main>';
        foreach ($posts as $post) {
            $main .= '<div class="my-16 bg-slate-800 p-10 rounded-xl">';
            $main .= '<a href="/post?id=' . $post->getId() . '">';
            $main .= '<h2 class="text-3xl text-monokaiGreen"><span class="text-monokaiRed">Title: </span>' . $post->getTitle() . '</h2>';
            $main .= '<p class="text-monokaiYellow"><span class="text-monokaiOrange">User_Name: </span>' . $post->getUserName() . '</p>';
            $main .= '<p class="text-monokaiYellow"><span class="text-monokaiOrange">Created_At: </span>' . substr(string:$post->getCreatedAt(), offset: 0, length:10 ). '</p>';
            $main .= '<img class="my-4 object-contain rounded-xl" src=' . $post->getThumbnail() . ' alt="image">';
            $main .= '<p class="text-md text-monokaiWhite">' . substr(string: $post->getBody(), offset: 0, length: 100) . '...</p>';
            $main .= '</a>';
            $main .= '</div>';
        }
        $main .= '</main>';
        return $main;
    }


    public function getHtml(): string
    {
        return $this->html;
    }
}