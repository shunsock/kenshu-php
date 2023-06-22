<?php

declare(strict_types=1);

namespace App\Html;

use App\Model\PostCollection;

class CreatePostPageHtml extends HtmlTemplate implements HtmlInterface
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
        $html .= $this->getFooter();
        $html .= '</body>';
        $html .= '</html>';
        $this->html = $html;
    }

    public function getMain(PostCollection $posts): string
    {
        $body = '<body>';
        foreach ($posts as $post) {
            if ($post->getId() == $_GET['id']) {
                $body .= '<div class="my-5 bg-slate-800 p-10 rounded-xl">';
                $body .= '<h2 class="text-3xl text-monokaiGreen"><span class="text-monokaiRed">Title: </span>' . $post->getTitle() . '</h2>';
                $body .= '<p class="text-monokaiYellow"><span class="text-monokaiOrange">Created_At: </span>' . $post->getCreatedAt() . '</p>';
                $body .= '<img class="my-4 object-contain rounded-xl" src=' . $post->getThumbnail() . ' alt="image">';
                $body .= '<p class="text-md text-monokaiWhite">' . $post->getBody() . '</p>';
                $body .= '</div>';
            }
        }
        $id = $_GET['id'];
        $body .= $this->getMenu($id);
        $body .= '</body>';
        return $body;
    }

    private function getMenu(string $id): string
    {
        $menu = '<div class="flex text-monokaiWhite text-lg py-10">';
        $menu .= '<a href="/edit?id=' . $id . '" class="inline-block w-[50%] text-center hover:font-bold pr-5 rounded-xl py-10"><div class="inline-block text-center w-full text-center hover:font-bold pr-5 rounded-xl bg-monokaiGreen py-3">Edit</div></a>';
        $menu .= '<form method="POST" action="/post?id=' . $id . '" class="inline-block w-[50%] text-monokaiWhite text-lg py-10 pl-5">';
        $menu .= '<input type="hidden" name="_method" value="delete">';
        $menu .= '<button type="submit" class="w-full text-center hover:font-bold pr-5 rounded-xl bg-monokaiRed py-3">Delete</button>';
        $menu .= '</form></div>';
        return $menu;
    }

    public function getHtml(): string
    {
        return $this->html;
    }
}