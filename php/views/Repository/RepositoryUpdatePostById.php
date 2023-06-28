<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\CreateConnectionPDO;

class RepositoryUpdatePostById
{
    public static function commit(
        string $id,
        string $title,
        string $body
    ): void
    {
        $query = "UPDATE post SET title=?, body=? WHERE id = ?";
        $db = CreateConnectionPDO::CreateConnection();
        $prepared = $db->prepare($query);
        $prepared->execute([$title, $body, $id]);
    }
}