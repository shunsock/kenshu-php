<?php

declare(strict_types=1);

namespace App\Html;

class CreateRegisterPageHtml extends HtmlTemplate implements HtmlInterface
{
    private string $html;

    public function __construct()
    {
        $html = '<!DOCTYPE html>';
        $html .= '<html lang="jp">';
        $html .= $this->getHead();
        $html .= '<body class="bg-slate-700 text-white px-[30%] my-10">';
        $html .= $this->getHeader();
        $html .= $this->getMain();
        $html .= $this->getLinkToLoginPage();
        $html .= $this->getFooter();
        $html .= '</body>';
        $html .= '</html>';
        $this->html = $html;
    }

    private function getMain(): string
    {
        $main = "";
        if (!empty($_SESSION['message'])) {
            $main .= '<div class="bg-monokaiRed px-5 py-3 my-3 rounded-lg">';
            $main .= '<h1">403 Bad Request</h1>';
            $main .= '<p class="text-monokaiWhite font-bold">' . $_SESSION['message'] . '</p>';
            $main .= '</div>';
            unset($_SESSION['message']);
        }
        $main .= '<form method="POST" action="/register" class="my-10" enctype="multipart/form-data">';
        $main .= '<h2 class="text-3xl text-monokaiWhite my-3">Register</h2>';
        $main .= '<label class="text-monokaiGreen text-lg font-bold">USER NAME</label>';
        $main .= '<input type="text" name="username" placeholder="username" class="text-slate-800 h-16 w-full rounded-lg bg-monokaiWhite px-16 py-5 my-5">';
        $main .= '<label class="text-monokaiGreen text-lg font-bold">EMAIL</label>';
        $main .= '<input type="text" name="email" placeholder="exmaple@example.com" class="text-slate-800 h-16 w-full rounded-lg bg-monokaiWhite px-16 py-5 my-5">';
        $main .=  '<label class="text-monokaiGreen text-lg font-bold">PROFILE IMAGE</label>';
        $main .= '<input type="file" name="user-image" class="text-slate-800 h-16 w-full rounded-lg bg-monokaiWhite px-16 py-5 my-5">';
        $main .= '<label class="text-monokaiGreen text-lg font-bold">PASSWORD</label>';
        $main .= '<input type="password" name="password" placeholder="password" class="text-slate-800 h-16 w-full rounded-lg bg-monokaiWhite px-16 py-5 my-5">';
        $main .= '<button type="submit" class="text-xl rounded-lg p-3 w-36 bg-slate-500 hover:bg-monokaiBlue text-center my-5">Submit</button>';
        $main .= '</form>';
        return $main;
    }

    private function getLinkToLoginPage(): string
    {
        return '<p class="py-5">If you already have account, Please <a href="/login" class="text-monokaiBlue text-lg font-bold">Login</a></p>';
    }

    public function getHtml(): string
    {
        return $this->html;
    }
}