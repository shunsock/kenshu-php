<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\CreateConnectionPDO;
use App\Core\StringArrayChecker;
use InvalidArgumentException;
use PDO;

class RepositoryRegister
{
    public static function commit(
        string $user_name,
        string $email,
        string $image_name,
        string $password_hashed
    ): void
    {
        $user_name_list = self::getAllUserName();
        if ($user_name_list->isExist($user_name)) {
            throw new InvalidArgumentException(message: "user name already exists");
        }
        // code below have possible to throw PDOException
        self::InsertUserData(
            user_name: $user_name
            , email: $email
            , image_name: $image_name
            , password_hashed: $password_hashed
        );
    }

    public static function getAllUserName(): StringArrayChecker
    {
        // code below have possible to throw PDOException
        $query = "SELECT name FROM users";
        $db = CreateConnectionPDO::CreateConnection();
        $user_names = $db->query($query)->fetchAll(mode: PDO::FETCH_COLUMN, args: 0);
        // code below have possible to throw Invalid Argument Exception
        return new StringArrayChecker($user_names);
    }

    public static function InsertUserData(
        string   $user_name
        , string $email
        , string  $image_name
        , string $password_hashed
    ): void
    {
        $query = "INSERT INTO users (name, email, user_image_path, password) VALUES (?,?,?,?)";
        $db = CreateConnectionPDO::CreateConnection();
        $prepared = $db->prepare($query);
        $prepared->execute([$user_name, $email, $image_name,  $password_hashed]);
    }
}