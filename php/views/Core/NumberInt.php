<?php
declare(strict_types=1);

namespace App\Core;

use InvalidArgumentException;

// NOTE: PHPの整数型の想定される入力の範囲が広いため制限するClass
// REFERENCE: https://www.php.net/manual/ja/language.types.integer.php
class NumberInt
{
    private int $value;

    public function __construct(int|string $value)
    {
        if (is_int($value)) {
            $value = (string)$value;
        }
        if (!preg_match(pattern: '/^[-+]?[0-9]+$/', subject: $value)) {
            throw new InvalidArgumentException(message: 'Not Integer');
        }
        $this->value = ((int)$value);
    }

    public function getValue(): int
    {
        return $this->value;
    }
}