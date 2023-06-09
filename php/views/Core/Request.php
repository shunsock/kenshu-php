<?php

namespace App\Core;

use http\Exception\InvalidArgumentException;

class Request
{
    private string $request_method;
    private string $uri;
    private GetParam $get_param;
    private array $post_data;

    public function __construct(
        $request_method,
        $uri,
        $get_param,
        $post_data
    )
    {
        if ($this->isHttpRequest($request_method) === false) {
            throw new InvalidArgumentException('Request method is invalid');
        }
        $this->request_method = $request_method;
        if ($this->isUriValid($uri) === false) {
            throw new InvalidArgumentException('Request path is invalid');
        }
        $this->uri = $uri;

        try {
            $this->get_param = new GetParam($get_param);
        } catch (InvalidArgumentException) {
            throw new InvalidArgumentException(message: 'Request query param is invalid');
        }

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
        if (in_array($request_name, ['GET', 'POST', 'PUT', 'DELETE'], true)) {
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

    public function getGetParam(): GetParam
    {
        return $this->get_param;
    }

    public function getPostData(): array
    {
        return $this->post_data;
    }
}