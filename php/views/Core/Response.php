<?php
declare(strict_types=1);

namespace App\Core;

use InvalidArgumentException;

class Response
{
    private string $status_code;
    private string $body;

    public function __construct(string $status_code, string $body)
    {
        if (!preg_match(pattern: '/^[1-5][0-9][0-9]$/', subject: $status_code)) {
            throw new InvalidArgumentException(message: 'Status code is invalid');
        }
        $this->status_code = $status_code;

        if ($body === "") {
            throw new InvalidArgumentException(message: 'Body is empty');
        }
        $this->body = $body;
    }

    public function getStatusCode(): string
    {
        return $this->status_code;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}