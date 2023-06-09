<?php

namespace App\Core;

class GetParam
{
    private array $getParam;
    private bool $isEmpty = false;

    public function __construct(array $input_arr)
    {
        if (0 === count($input_arr)) {
            $this->getParam = $input_arr;
            $this->isEmpty = true;
            return;
        }
        if ($this->isArrayValuesTypeSame($input_arr) === false) {
            throw new \InvalidArgumentException(message:'Array values type is not same');
        }
        if ($this->isArrayKeyValid($input_arr) === false) {
            throw new \InvalidArgumentException(message:'Array keys is not valid');
        }
        $this->getParam = $input_arr;
    }

    private function isArrayValuesTypeSame(array $arr): bool
    {
        if (count($arr) === 0) {
            throw new \InvalidArgumentException(message: 'Array is empty');
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
            throw new \InvalidArgumentException(message: 'Array is empty');
        }
        foreach (array_keys($arr) as $key) {
            if (!is_string($key)) {
                return false;
            }
        }
        return true;
    }

    public function getRequest(): array
    {
        return $this->getParam;
    }

    public function isEmpty(): bool
    {
        return $this->isEmpty;
    }}