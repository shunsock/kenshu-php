<?php

namespace App\Core;

use InvalidArgumentException;

class GetParamChecker
{
    /**
     * @param array $input_arr
     * @return bool
     */
    public static function isGetParamValid(array $input_arr): bool
    {
        if (0 === count($input_arr)) {
            return true;
        }
        if (self::isArrayValuesTypeSame($input_arr) === false) {
            return false;
        }
        if (self::isArrayKeyValid($input_arr) === false) {
            return false;
        }
        return true;
    }

    private static function isArrayValuesTypeSame(array $arr): bool
    {
        if (count($arr) === 0) {
            throw new InvalidArgumentException(message: 'Array is empty');
        }
        foreach ($arr as $item) {
            if (!is_string($item)) {
                return false;
            }
        }
        return true;
    }

    private static function isArrayKeyValid(array $arr): bool
    {
        if (count($arr) === 0) {
            throw new InvalidArgumentException(message: 'Array is empty');
        }
        foreach (array_keys($arr) as $key) {
            if (!is_string($key)) {
                return false;
            }
        }
        return true;
    }
}