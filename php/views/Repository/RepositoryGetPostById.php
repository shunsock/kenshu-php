<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\CreateConnectionPDO;
use App\Model\Post;
use Exception;

class RepositoryGetPostById
{
    public static function getData(string $id): Post
    {
        // run query for database
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
        $db = CreateConnectionPDO::CreateConnection();
        $id = $params["id"];
        $prepared = $db->prepare($query);
        $prepared->execute([$id]);
        $post = $prepared->fetchAll();
        if (count($post) !== 1) {
            throw new Exception(message: "post not found");
        }

        // attach type to data
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
}