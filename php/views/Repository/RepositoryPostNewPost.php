<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\CreateConnectionPDO;

class RepositoryPostNewPost
{
    public static function commit(
        string $title,
        string $body
    ): void
    {
        // TODO: 画像のアップロード機能を作成する
        $user_id_string = (string) $_SESSION['user_id'];
        $query = "INSERT INTO post (title, user_id, thumbnail, body) VALUES (?, ?, 'https://images.unsplash.com/photo-1506606401543-2e73709cebb4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80', ?);";
        $db = CreateConnectionPDO::CreateConnection();
        $prepared = $db->prepare($query);
        $prepared->execute([$title, $user_id_string,  $body]);
    }
}