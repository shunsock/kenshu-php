<?php

declare(strict_types=1);

namespace App\Core;

class CreateHtml
{
    private string $html;
    private function getHead(): string
    {
        $head = '<head>';
        $head .= '<meta charset="UTF-8">';
        $head .= '<title>My Blog</title>';
        $head .= '</head>';
        return $head;
    }
    private function getHeader(): string
    {
        $header = '<header>';
        $header .= '<h1>String Object is All You Need</h1>';
        $header .= '</header>';
        return $header;
    }
    private function getFooter(): string
    {
        $footer = '<footer>';
        $footer .= '<p>@copy right: Shunsock</p>';
        $footer .= '</footer>';
        return $footer;
    }
    public function __construct(string $body)
    {
        $html = '<!DOCTYPE html>';
        $html .= '<html>';
        $html .= $this->getHead();
        $html .= $this->getHeader();
        $html .= $body;
        $html .= $this->getFooter();
        $html .= '</html>';
        $this->html = $html;
    }
    public function getHtml(): string
    {
        return $this->html;
    }
}