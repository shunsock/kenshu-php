<?php

declare(strict_types=1);

namespace App\Html;

class CreateInternalServerErrorHtml extends HtmlTemplate implements HtmlInterface
{
    private string $html;

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
        $this->html = $html;
    }

    private function getMain(): string
    {
        $main = '<main>';
        $main .= '<h1>404 Not Found</h1>';
        $main .= '<p>お探しのページは見つかりませんでした。</p>';
        $main .= '</main>';
        return $main;
    }

    public function getHtml(): string
    {
        return $this->html;
    }
}