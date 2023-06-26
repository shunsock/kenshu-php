<?php

declare(strict_types=1);

namespace App\Html;

use App\Model\Post;

class CreatePostPageHtml extends HtmlTemplate implements HtmlInterface
{
    private string $html;
    private bool $isAuthorOfPost;

    public function __construct(Post $post)
    {
        // Server have session because of function on Router (isUserLoggedIn)
        if ($post->getUserName() === $_SESSION["user_name"]) {
            $this->isAuthorOfPost = true;
        } else {
            $this->isAuthorOfPost = false;
        }

        $html = '<!DOCTYPE html>';
        $html .= '<html lang="jp">';
        $html .= $this->getHead();
        $html .= '<body class="bg-slate-700 text-white px-[30%] my-10">';
        $html .= $this->getHeader();
        $html .= $this->getNavbar();
        $html .= $this->getMain($post);
        $html .= $this->getFooter();
        $html .= '</body>';
        $html .= '</html>';
        $this->html = $html;

    }

    public function getMain(Post $post): string
    {
        $main = '<body>';
        $main .= '<div class="my-5 bg-slate-800 p-10 rounded-xl">';
        $main .= '<h2 class="text-3xl text-monokaiGreen"><span class="text-monokaiRed">Title: </span>' . $post->getTitle() . '</h2>';
        $main .= '<p class="text-monokaiYellow"><span class="text-monokaiOrange">User_Name: </span>' . $post->getUserName() . '</p>';
        $main .= '<p class="text-monokaiYellow"><span class="text-monokaiOrange">Created_At: </span>' . substr(string: $post->getCreatedAt(), offset: 0, length: 10) . '</p>';
        $main .= '<img class="my-4 object-contain rounded-xl" src=' . $post->getThumbnail() . ' alt="image">';
        $main .= '<p class="text-md text-monokaiWhite">' . $post->getBody() . '</p>';
        $main .= '</div>';

        $id = $_GET['id'];
        $main .= $this->getMenu($id);
        $main .= '</body>';
        return $main;
    }

    private function getMenu(string $id): string
    {
        $edit_action = $this->isAuthorOfPost ? "/edit?id=" . $id : "/not-author";
        $menu = '<div class="flex text-monokaiWhite text-lg py-10">';
        $menu .= '<a href="' . $edit_action . '" class="inline-block w-[50%] text-center hover:font-bold pr-5 rounded-xl py-10"><div class="inline-block text-center w-full text-center hover:font-bold pr-5 rounded-xl bg-monokaiGreen py-3">Edit</div></a>';

        $delete_action = $this->isAuthorOfPost ? "/post?id=" . $id : "/not-author";
        $menu .= '<form method="POST" action="' . $delete_action . '" class="inline-block w-[50%] text-monokaiWhite text-lg py-10 pl-5">';
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