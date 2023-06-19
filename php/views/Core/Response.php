<?php
declare(strict_types=1);

namespace App\Core;


use InvalidArgumentException;

class Response
{
    private string $statusCode;
    private string $body;

    public function __construct(string $status_code, string $body)
    {
        if (!preg_match(pattern: '/^[1-5][0-9][0-9]$/', subject: $status_code)) {
            throw new InvalidArgumentException(message: 'Status code is invalid');
        }
        $this->statusCode = $status_code;

        if ($body === "") {
            throw new InvalidArgumentException(message: 'Body is empty');
        }
        $this->body = $body;
    }

    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}