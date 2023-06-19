<?php

declare(strict_types=1);

namespace App\Html;

class CreateBadRequestHtml extends HtmlTemplate implements HtmlInterface
{
    private string $Html;

    public function __construct()
    {
        $html = '<!DOCTYPE html>';
        $html .= '<html lang="jp">';
        $html .= $this->getHead();
        $html .= '<body class="bg-slate-700 text-white px-[30%] my-10">';
        $html .= $this->getHeader();
        $html .= $this->getNavbar();
        $html .= $this->getMain();
        $html .= $this->getFooter();
        $html .= '</body></html>';
        $this->Html = $html;
    }

    private function getMain(): string
    {
        $main = '<main>';
        $main .= '<div class="bg-monokaiRed px-5 py-3 my-3 rounded-lg">';
        $main .= '<h1">403 Bad Request</h1>';
        $main .= '<p>不正な値が検出されました。入力情報をお確かめください</p>';
        $main .= '</div>';
        $main .= '</main>';
        return $main;
    }

    public function getHtml(): string
    {
        return $this->Html;
    }
}