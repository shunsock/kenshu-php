<?php

declare(strict_types=1);

namespace App\Html;

class CreateLoginPageHtml extends HtmlTemplate implements HtmlInterface
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
        $html .= $this->getLinkToRegisterPage();
        $html .= $this->getFooter();
        $html .= '</body>';
        $html .= '</html>';
        $this->html = $html;
    }

    private function getMain(): string
    {
        $main = '<form method="POST" action="/login" class="my-10">';
        $main .= '<h2 class="text-3xl text-monokaiWhite my-3">Login</h2>';
        $main .= '<label class="text-monokaiGreen text-lg font-bold">USER NAME</label>';
        $main .= '<input type="text" name="username" placeholder="username" class="text-slate-800 h-16 w-full rounded-lg bg-monokaiWhite px-16 py-5 my-5">';
        $main .= '<label class="text-monokaiGreen text-lg font-bold">PASSWORD</label>';
        $main .= '<input type="password" name="password" placeholder="password" class="text-slate-800 h-16 w-full rounded-lg bg-monokaiWhite px-16 py-5 my-5">';
        $main .= '<button type="submit" class="text-xl rounded-lg p-3 w-36 bg-slate-500 hover:bg-monokaiBlue text-center my-5">Submit</button>';
        $main .= '</form>';
        return $main;
    }

    private function getLinkToRegisterPage(): string
    {
        $link = '<p class="py-5">If you do not have account, Please <a href="/register" class="text-monokaiBlue text-lg font-bold">Register</a></p>';
        return $link;
    }

    public function getHtml(): string
    {
        return $this->html;
    }
}