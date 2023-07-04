<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\CreateConnectionPDO;
use App\Core\StringArrayChecker;
use InvalidArgumentException;

class RepositoryPostNewPost
{
    public static function commit(
        string $title,
        string $body,
        array $image_paths
    ): void
    {
        try {
            new StringArrayChecker($image_paths);
        } catch (InvalidArgumentException) {
            throw new InvalidArgumentException(message: "image_names is not string array");
        }
        // TODO: 画像のアップロード機能を作成する
        $user_id_string = (string) $_SESSION['user_id'];
        $query = "INSERT INTO post (title, user_id, thumbnail, body) VALUES (?, ?, ?,?);";
        $db = CreateConnectionPDO::CreateConnection();
        $prepared = $db->prepare($query);
        $prepared->execute([$title, $user_id_string,$image_paths, $body]);

        // get id of the created post
        $row = $prepared->fetch();
        $id = $row['id'];

        // insert image paths into image table
        // N+1 Problem is occurred here, but we do not have idea to solve it.
        // Because we predict perfectly that the number of images is less than 10.
        foreach ($image_paths as $image_path) {
            $query_for_image = "INSERT INTO image (post_id, path) VALUES (?, ?);";
            $prepared_for_image = $db->prepare($query_for_image);
            $prepared_for_image->execute([$id, $image_path]);
        }
    }
}