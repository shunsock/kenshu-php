<?php

declare(strict_types=1);

namespace App\Model;

use App\Core\NumberInt;
use InvalidArgumentException;

class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $created_at;
    private string $updated_at;
    private string $deleted_at;

    public function __construct(
        int    $id,
        string $name,
        string $email,
        string $password,
        string $created_at,
        string $updated_at,
               $deleted_at
    )
    {
        if (self::isIdValid($id) === false) {
            throw new InvalidArgumentException(message: 'id must be a positive integer');
        }
        $this->id = $id;
        $this->name = $name;

        if (self::isEmailValid($email) === false) {
            throw new InvalidArgumentException(message: 'email is invalid');
        }
        $this->email = $email;

        $this->password = $password;

        $this->created_at = $created_at;

        $this->updated_at = $updated_at;

        if ($deleted_at) {
            $this->deleted_at = $deleted_at;
        }
    }

    private function isIdValid(int $id): bool
    {
        try {
            $num = new NumberInt($id);
        } catch (InvalidArgumentException) {
            return false;
        }

        if ($num->getValue() < 0) {
            return false;
        }

        return true;
    }

    private function isEmailValid(string $email): bool
    {
        $isEmailValid = preg_match(
            pattern: '/^[a-zA-Z0-9_+-]+(.[a-zA-Z0-9_+-]+)*@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/'
            , subject: $email
        );
        if ($isEmailValid) {
            return true;
        } else {
            return false;
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function checkPassword(string $password): bool
    {
        if (password_verify(password: $password, hash: $this->password)) {
            return true;
        } else {
            return false;
        }
    }
}