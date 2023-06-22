<?php

declare(strict_types=1);

namespace App\Html;


class CreateEditPageHtml extends HtmlTemplate implements HtmlInterface
{
    private string $html;

    public function __construct(int $id, string $title, string $body)
    {
        $html = '<!DOCTYPE html>';
        $html .= '<html lang="jp">';
        $html .= $this->getHead();
        $html .= '<body class="bg-slate-700 text-white px-[30%] my-10">';
        $html .= $this->getHeader();
        $html .= $this->getNavbar();
        $html .= $this->getMain((string)$id, $title, $body);
        $html .= $this->getFooter();
        $html .= '</body>';
        $html .= '</html>';
        $this->html = $html;
    }

    protected function getMain(
        string $id,
        string $title,
        string $body,
    ): string
    {
        $form = '<form method="POST" action="/edit?id=' . $id . '">';
        $form .= '<h2 class="text-3xl text-monokaiWhite">Create New Post</h2>';
        $form .= '<input type="hidden" name="_method" value="put">';
        $form .= '<input type="text" name="title" value="' . $title . '" class="text-slate-800 h-20 w-full rounded-lg bg-monokaiWhite px-16 py-5 my-5">';
        $form .= '<textarea name="body" class="text-slate-800 h-96 w-full rounded-lg bg-monokaiWhite px-16 py-5">' . $body . '</textarea>';
        $form .= '<button type="submit" class="text-xl rounded-lg p-3 w-36 bg-slate-500 hover:bg-monokaiBlue text-center my-5">Submit</button>';
        $form .= '</form>';
        return $form;
    }

    public function getHtml(): string
    {
        return $this->html;
    }
}
