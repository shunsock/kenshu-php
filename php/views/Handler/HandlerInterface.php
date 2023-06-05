<?php

namespace App\views\Handler\HandleInterface;

interface HandlerInterface
{
    public function run(array $req): array;
}