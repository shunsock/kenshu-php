<?php
namespace App\Core;
use http\Exception\InvalidArgumentException as InvalidArgumentExceptionAlias;

class GetParam
{
    private array $getParam;
    private bool $isEmpty=false;

    public function __construct(array $input_arr)
    {
        if (0 === count($input_arr)) {
            $this->getParam=$input_arr;
            $this->isEmpty=true;
            return;
        }
        if ($this->isArrayValuesTypeSame($input_arr) === false) {
            throw new InvalidArgumentExceptionAlias('Array values type is not same');
        }
        if ($this->isArrayKeyValid($input_arr) === false) {
            throw new InvalidArgumentExceptionAlias('Array keys is not valid');
        }
        $this->getParam = $input_arr;
    }
    private function isArrayValuesTypeSame(array $arr): bool
    {
        if (count($arr) === 0) {
            throw new InvalidArgumentExceptionAlias('Array is empty');
        }
        foreach ($arr as $item) {
            if (!is_string($item)) {
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
    public function getRequest(): array
    {
        return $this->getParam;
    }
    public function isEmpty(): bool
    {
        return $this->isEmpty;
    }
}