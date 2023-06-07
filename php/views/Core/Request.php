<?php
namespace App\Core;
use Couchbase\PathNotFoundException;
use http\Exception\InvalidArgumentException;

class Request
{
    private string $request_method;
    private string $path;
    private GetParam $get_param;
    private array $post_data;

    public function __construct(
        $request_method,
        $path,
        $get_param,
        $post_data
    )
    {
        if ($this->isHttpRequest($request_method) === false) {
            throw new InvalidArgumentException('Request method is invalid');
        }
        $this->request_method = $request_method;
        if ($this->isDirectoryExist($path) === false) {
            throw new InvalidArgumentException('Request path is invalid');
        }
        $this->path = $path;

        try {
            $this->get_param = new GetParam($get_param);
        } catch ( InvalidArgumentException $e) {
            throw new InvalidArgumentException( $e, 'Request query param is invalid');
        }

        if ($this->isPostDataValid($post_data) === false) {
            throw new InvalidArgumentException('Request data is invalid');
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
     * @param string $path
     * @return bool
     */
    private function isDirectoryExist(string $path): bool
    {
        if (is_dir($path)) {
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
            if (gettype($value) !== 'string') {
                return false;
            }
        }
        return true;
    }

    public function getRequestMethod(): string
    {
        return $this->request_method;
    }
    public function getPath(): string
    {
        return $this->path;
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