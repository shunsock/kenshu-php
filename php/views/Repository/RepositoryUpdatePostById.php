<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\CreateConnectionPDO;

class RepositoryUpdatePostById
{
    public static function updatePost(
        string $id,
        string $title,
        string $body
    ): void
    {
        $query = "UPDATE post SET title=?, body=? WHERE id = ?";
        self::query_run(
            query: $query,
            id: $id,
            title: $title,
            body: $body
        );
    }

    public static function query_run(
        string $query,
        string $id,
        string $title,
        string $body
    ): void
    {
        $db = CreateConnectionPDO::CreateConnection();
        $prepared = $db->prepare($query);
        $prepared->execute([$title, $body, $id]);
    }
}