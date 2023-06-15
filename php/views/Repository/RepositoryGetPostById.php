<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\CreateConnectionPDO;
use App\Model\Post;
use App\Model\PostCollection;
use PDOException;

class RepositoryGetPostById implements RepositoryInterface
{
    public static function getPostById(string $id): PostCollection
    {
        $params = ['id' => $id];
        $query = "SELECT * FROM post WHERE id = ?";
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
            $post = new Post($id, $title, $user_id, $thumbnail, $body, $updated_at, $created_at);
            $posts->append($post);
        }
        return $posts;
    }

    public static function query_run(string $query, array $params = []): array
    {
        $db = CreateConnectionPDO::CreateConnection();
        try {
            $id = $params["id"];
            $prepared = $db->prepare($query);
            $prepared->execute([$id]);
            $result = $prepared->fetchAll();
        } catch (PDOException) {
            throw new PDOException(message: 'SQL Processing Failed');
        }
        return $result;
    }
}