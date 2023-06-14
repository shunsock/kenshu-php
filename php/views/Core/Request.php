<?php

namespace App\Core;

use InvalidArgumentException;

class Request
{
    private string $request_method;
    private string $uri;
    private array $get_param;
    private array $post_data;

    public function __construct(
        string $request_method,
        string $uri,
               $get_param,
               $post_data
    )
    {
        if ($this->isHttpRequest($request_method) === false) {
            throw new InvalidArgumentException(message: 'Request method is invalid');
        }
        $this->request_method = $request_method;
        if ($this->isUriValid($uri) === false) {
            throw new InvalidArgumentException(message: 'Request path is invalid');
        }
        $this->uri = $uri;

        if (GetParamChecker::isGetParamValid($get_param) === false) {
            throw new InvalidArgumentException(message: 'Request query param is invalid');
        }
        $this->get_param = $get_param;

        if ($this->isPostDataValid($post_data) === false) {
            throw new InvalidArgumentException(message: 'Request data is invalid');
        }
        $this->post_data = $post_data;
    }

    /**
     * @param string $request_name
     * @return bool
     */
    private function isHttpRequest(string $request_name): bool
    {
        if (in_array(needle: $request_name, haystack: ['GET', 'POST', 'PUT', 'DELETE'], strict: true)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $uri
     * @return bool
     */
    private function isUriValid(string $uri): bool
    {
        if (preg_match(pattern: '/^([\/]?([a-zA-Z]+)*(\?[a-zA-Z]+=[a-zA-Z0-9]+)?)$/', subject: $uri)) {
            return true;
        } else {
            return false;
        }
    }

    private function isPostDataValid(array $arr): bool
    {
        if (count($arr) === 0) {
            return true;
        }
        foreach ($arr as $value) {
            if (!is_string($value)) {
                return false;
            }
        }
        return true;
    }

    public function getRequestMethod(): string
    {
        return $this->request_method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getParam(): array
    {
        return $this->get_param;
    }
    public function getPostData(): array
    {
        return $this->post_data;
    }
}