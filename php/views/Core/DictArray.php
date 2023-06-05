<?php
declare(strict_types=1);
namespace php\views\Core;
use http\Exception\InvalidArgumentException as InvalidArgumentExceptionAlias;

class DictArray
{
    private function __construct(array $input_arr)
    {
        if ($this->isArrayValuesTypeSame($input_arr) === false) {
            throw new InvalidArgumentExceptionAlias('Array values type is not same');
        }
        if ($this->isArrayKeyValid($input_arr) === false) {
            throw new InvalidArgumentExceptionAlias('Array keys is not valid');
        }
    }
    private function isArrayValuesTypeSame(array $arr): bool
    {
        if (count($arr) === 0) {
            throw new InvalidArgumentExceptionAlias('Array is empty');
        }
        $type = gettype($arr[0]);
        foreach ($arr as $value) {
            if (gettype($value) !== 'string') {
                return false;
            }
        }
        return true;
    }

    private function isArrayKeyValid(array $arr): bool
    {
        if (count($arr) === 0) {
            return false;
        }
        foreach($arr as $key => $value) {
            if (gettype($key) !== 'string') {
                return false;
            }
        }
        return true;
    }
}
