<?php
namespace php\views\Core;
use http\Exception\InvalidArgumentException as InvalidArgumentExceptionAlias;

class ListArray
{
    public function isListArrayValid(array $input_arr)
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
        foreach ($arr as $item) {
            if ($type != gettype($item)) {
                return false;
            }
        }
        return true;
    }

    private function isArrayKeyValid(array $arr): bool
    {
        if (count($arr) === 0) {
            throw new InvalidArgumentExceptionAlias('Array is empty');
        }
        $keys = array_keys($arr);
        $is_list = $keys === range(0, count($arr) - 1);
        if ($is_list) {
            return true;
        } else {
            return false;
        }
    }
}