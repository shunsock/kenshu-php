<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\CreateConnectionPDO;

class RepositoryDeletePostById
{
    public static function commit(
        string $id
    ): void
    {
        $query = "DELETE from post WHERE id = ?";
        $db = CreateConnectionPDO::CreateConnection();
        $prepared = $db->prepare($query);
        $prepared->execute([$id]);
    }
}