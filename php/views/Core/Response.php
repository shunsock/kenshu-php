<?php
declare(strict_types=1);

namespace App\Core;


use AllowDynamicProperties;
use InvalidArgumentException;

#[AllowDynamicProperties] class Response
{
    private string $statusCode;
    private string $body;

    private ?string $redirect_location = null;

    public function __construct(
        string $status_code,
        string $body,
        string $redirect_location = ""
    )
    {
        if (!preg_match(pattern: '/^[1-5][0-9][0-9]$/', subject: $status_code)) {
            throw new InvalidArgumentException(message: 'Status code is invalid');
        }
        $this->statusCode = $status_code;

        if ($body === "") {
            throw new InvalidArgumentException(message: 'Body is empty');
        }
        $this->body = $body;

        $this->redirect_location = $redirect_location;

    }

    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getRedirectLocation(): string
    {
        return $this->redirect_location;
    }
}