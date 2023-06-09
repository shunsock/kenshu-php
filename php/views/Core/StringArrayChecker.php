<?php

declare(strict_types=1);

namespace App\Core;

use InvalidArgumentException;

class StringArrayChecker
{
    private int $length = 0;

    private array $arr;

    public function __construct(array $arr)
    {
        foreach ($arr as $key => $value) {
            // if array type is not `string[]` throw exception
            if ($this->length !== $key) {
                throw new InvalidArgumentException(message: 'Array is not sequential');
            }
            $this->length++;

            if (!is_string($value)) {
                throw new InvalidArgumentException(message: 'StringArrayChecker\'s value type must be string');
            }
        }
        $this->arr = $arr;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    // type of object which returned is MUST `string[]` because of constructor\'s function
    public function getArr(): array
    {
        return $this->arr;
    }

    public function isExist(string $str): bool
    {
        if (in_array($str, $this->arr, strict: true)) {
            return true;
        }
        return false;
    }
}