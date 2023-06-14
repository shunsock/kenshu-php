<?php

declare(strict_types=1);

namespace App\Core;

class CreateHtml
{
    private string $html;

    public function __construct(string $content)
    {
        $html = '<!DOCTYPE html>';
        $html .= '<html>';
        $html .= $this->getHead();
        $html .= '<body class="bg-slate-700 text-white px-[30%] my-10">';
        $html .= $this->getHeader();
        $html .= $this->getNavbar();
        $html .= $content;
        $html .= $this->getForm();
        $html .= $this->getFooter();
        $html .= '</body>';
        $html .= '</html>';
        $this->html = $html;
    }

    private function getHead(): string
    {
        $head = '<head>';
        $head .= '<meta charset="UTF-8">';
        $head .= '<title>My Blog</title>';
        $head .= '<script src="https://cdn.tailwindcss.com"></script>';
        $head .= <<<EOT
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            monokaiComments: "#75715E",
                            monokaiWhite: "#F8F8F2",
                            monokaiYellow: "#E6DB74",
                            monokaiGreen: "#A6E22E",
                            monokaiOrange: "#FD971F",
                            monokaiPurple: "#AE81FF",
                            monokaiRed: "#F92672",
                            monokaiBlue: "#66D9EF",
                       
                        }
                    }
                }
            }
        </script>
        EOT;
        $head .= '</head>';
        return $head;
    }

    private function getHeader(): string
    {
        $header = '<header>';
        $header .= '<h1 class="text-5xl text-monokaiWhite">String Object is All You Need</h1>';
        $header .= '<p class="text-monokaiComments my-5 ml-1">Make Your Life Better with String Object.</p>';
        $header .= '</header>';
        return $header;
    }

    private function getNavbar(): string
    {
        $navbar = '<nav class="">';
        $navbar .= '<ul class="list-none flex text-monokaiWhite text-lg">';
        $navbar .= '<li class="w-[50%] text-center hover:font-bold pr-5"><a href="/"><div class="rounded-xl bg-slate-500 hover:bg-monokaiBlue py-3">Home</div></a></li>';
        // TODO: Add Login Button and Logout Button
        $navbar .= '<li class="w-[50%] text-center hover:font-bold pr-5"><a href="/"><div class="rounded-xl bg-slate-500 hover:bg-monokaiBlue py-3">Tentative Button</div></a></li>';
        $navbar .= '</ul>';
        $navbar .= '</nav>';
        return $navbar;
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

    private function getFooter(): string
    {
        $footer = '<footer>';
        $footer .= '<p class="text-monokaiComments">@copy right: Shunsock</p>';
        $footer .= '</footer>';
        return $footer;
    }

    public function getHtml(): string
    {
        return $this->html;
    }
}