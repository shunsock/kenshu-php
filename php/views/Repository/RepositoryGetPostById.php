<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\CreateConnectionPDO;
use App\Model\Post;
use App\Model\PostCollection;

class RepositoryGetPostById implements RepositoryInterface
{
    public static function getPostById(string $id): Post
    {
        $params = ['id' => $id];
        $query = <<<EOT
            SELECT
                p.id,
                p.title,
                p.user_id,
                p.thumbnail,
                p.body,
                p.updated_at,
                p.created_at,
                u.name
            FROM post p
            JOIN users u
            ON p.user_id = u.id
            WHERE p.id = ?
            ORDER BY created_at DESC
        EOT;
        $post = self::query_run($query, $params);
        if (count($post) !== 1) {
            throw new \Exception(message: "post not found");
        }

        $id = $post[0]['id'];
        $title = $post[0]['title'];
        $user_id = $post[0]['user_id'];
        $thumbnail = $post[0]['thumbnail'];
        $body = $post[0]['body'];
        $updated_at = $post[0]['updated_at'];
        $created_at = $post[0]['created_at'];
        $user_name = $post[0]['name'];

        $post = new Post(
            id: $id
            , title: $title
            , user_id: $user_id
            , thumbnail: $thumbnail
            , body: $body
            , updated_at: $updated_at
            , created_at: $created_at
            , user_name: $user_name
        );

        return $post;
    }

    public static function query_run(string $query, array $params = []): array
    {
        $db = CreateConnectionPDO::CreateConnection();
        $id = $params["id"];
        $prepared = $db->prepare($query);
        $prepared->execute([$id]);
        $result = $prepared->fetchAll();
        return $result;
    }
}