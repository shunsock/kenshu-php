<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\CreateConnectionPDO;
use App\Model\Post;
use App\Model\PostCollection;

class RepositoryGetPostById implements RepositoryInterface
{
    public static function getPostById(string $id): PostCollection
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
        $res = self::query_run($query, $params);
        $posts = new PostCollection();
        foreach ($res as $post) {
            $id = $post['id'];
            $title = $post['title'];
            $user_id = $post['user_id'];
            $thumbnail = $post['thumbnail'];
            $body = $post['body'];
            $updated_at = $post['updated_at'];
            $created_at = $post['created_at'];
            $user_name = $post['name'];

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
            $posts->append($post);
        }
        return $posts;
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