<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\CreateConnectionPDO;
use PDOException;

class RepositoryPostNewPost
{
    public static function postNewPost(
        string $title,
        string $body
    ): void
    {
        // TODO: 画像のアップロード機能を作成する
        $query = "INSERT INTO post (title, user_id, thumbnail, body) VALUES (?, 1, 'https://images.unsplash.com/photo-1506606401543-2e73709cebb4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80', ?);";
        self::query_run($query, $title, $body);
    }

    public static function query_run(string $query, string $title, string $body): void
    {
        $db = CreateConnectionPDO::CreateConnection();
        try {
            $prepared = $db->prepare($query);
            $prepared->execute([$title, $body]);
        } catch (PDOException $e) {
            throw new PDOException(message: 'SQL Processing Failed: ' . $e->getMessage() . '');
        }
    }
}