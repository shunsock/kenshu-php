<?php
namespace App\Core;
use App\Core\DictArray;

class Request
{
    private string $method;
    private string $path;
    private array $get;
    private array $post;

    public function __construct()
    {
        if ($this->isHttpRequest($_SERVER['REQUEST_METHOD']) === false) {
            throw new InvalidArgumentException('Request method is not valid');
        }
        if ($this->isDirectoryExist($_SERVER['REQUEST_URI']) === false) {
            throw new InvalidArgumentException('Request path is not valid');
        }
        if ($this->isQueryParamValid($_GET) === false) {
            throw new InvalidArgumentException('Request query param is not valid');
        }
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = $_SERVER['REQUEST_URI'];
        $this->get = $_GET;
        $this->post = $_POST;
    }

    private function isHttpRequest(string $request_name): bool
    {
        if (in_array($request_name, ['GET', 'POST', 'PUT', 'DELETE'], true)) {
            return true;
        } else {
            return false;
        }
    }

    private function isDirectoryExist(string $path): bool
    {
        if (is_dir($path)) {
            return true;
        } else {
            return false;
        }
    }

    private function isQueryParamValid(array $arr): bool
    {
        if (count($arr) === 0) {
            return true;
        } else {
            $tmp = DictArray($arr);
        }
        return true;
    }
}