<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\CreateConnectionPDO;
use App\Model\Post;
use App\Model\PostCollection;
use PDOException;

class RepositoryGetAllPost implements RepositoryInterface
{
    public static function getAllPosts(): PostCollection
    {
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
            ORDER BY created_at DESC
        EOT;
        $res = self::query_run($query);
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
                , created_at: $created_at
                , updated_at: $updated_at
                , user_name: $user_name
            );
            $posts->append($post);
        }
        return $posts;
    }

    public static function query_run(string $query, array $params = []): array
    {
        $db = CreateConnectionPDO::CreateConnection();
        // catchはHandler
        try {
            $res = $db->query($query)->fetchAll();
        } catch (PDOException) {
            throw new PDOException(message: 'SQL Processing Failed');
        }
        return $res;
    }
}