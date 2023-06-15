<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\CreateConnectionPDO;
use PDOException;

class RepositoryDeletePost
{
    public static function deletePost(
        string $id
    ): void
    {
        $query = "DELETE from post WHERE id = ?";
        self::query_run($query, $id);
    }

    public static function query_run(string $query, string $id): void
    {
        $db = CreateConnectionPDO::CreateConnection();
        $prepared = $db->prepare($query);
        $prepared->execute([$id]);
    }
}