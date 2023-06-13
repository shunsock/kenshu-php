<?php

declare(strict_types=1);

namespace App\Repository;

Interface RepositoryInterface
{
    public static function query_run(string $query, array $params = []): array;
}